<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'title_es',
        'title_en',
        'slug',
        'category_es',
        'category_en',
        'date_label_es',
        'date_label_en',
        'location_es',
        'location_en',
        'image',
        'starts_at',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'starts_at' => 'date',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('starts_at')->orderBy('id');
    }

    public function title(?string $locale = null): string
    {
        $locale ??= App::getLocale();

        return $locale === 'en'
            ? ($this->title_en ?: $this->title_es)
            : ($this->title_es ?: $this->title_en);
    }

    public function category(?string $locale = null): string
    {
        $locale ??= App::getLocale();

        return $locale === 'en'
            ? ($this->category_en ?: $this->category_es ?: '')
            : ($this->category_es ?: $this->category_en ?: '');
    }

    public function dateLabel(?string $locale = null): string
    {
        $locale ??= App::getLocale();

        return $locale === 'en'
            ? ($this->date_label_en ?: $this->date_label_es ?: '')
            : ($this->date_label_es ?: $this->date_label_en ?: '');
    }

    public function location(?string $locale = null): string
    {
        $locale ??= App::getLocale();

        return $locale === 'en'
            ? ($this->location_en ?: $this->location_es ?: '')
            : ($this->location_es ?: $this->location_en ?: '');
    }

    public function imageUrl(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (
            str_starts_with($this->image, 'http://')
            || str_starts_with($this->image, 'https://')
            || str_starts_with($this->image, '/')
        ) {
            return $this->image;
        }

        if (Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        return asset($this->image);
    }

    /**
     * @return array{id: int, title: string, category: string, date: string, location: string, image: string, categoryKey: string, startsAt: string|null}
     */
    public function toCardItem(): array
    {
        $category = $this->category();
        $categoryKey = \Illuminate\Support\Str::slug($this->category_es ?: $category);

        return [
            'id' => $this->id,
            'title' => $this->title(),
            'category' => $category,
            'categoryKey' => $categoryKey,
            'date' => $this->dateLabel(),
            'location' => $this->location(),
            'image' => $this->imageUrl() ?? asset('images/eventos/flii-2026.png'),
            'startsAt' => optional($this->starts_at)?->toDateString(),
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Event $event): void {
            if (filled($event->slug)) {
                return;
            }

            $base = Str::slug($event->title_es ?: $event->title_en ?: 'evento');
            $slug = $base;
            $i = 2;

            while (static::query()
                ->where('slug', $slug)
                ->when($event->exists, fn (Builder $q) => $q->whereKeyNot($event->getKey()))
                ->exists()
            ) {
                $slug = $base.'-'.$i;
                $i++;
            }

            $event->slug = $slug;
        });
    }
}
