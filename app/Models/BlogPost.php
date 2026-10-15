<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'title_es',
        'title_en',
        'slug',
        'author',
        'published_at',
        'excerpt_es',
        'excerpt_en',
        'body_es',
        'body_en',
        'image',
        'category',
        'filter_secondary',
        'filter_tertiary',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'published_at' => 'datetime',
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
        return $query->orderByDesc('published_at')->orderBy('sort_order')->orderByDesc('id');
    }

    public function title(?string $locale = null): string
    {
        $locale ??= App::getLocale();

        return $locale === 'en'
            ? ($this->title_en ?: $this->title_es)
            : ($this->title_es ?: $this->title_en);
    }

    public function excerpt(?string $locale = null): ?string
    {
        $locale ??= App::getLocale();

        return $locale === 'en'
            ? ($this->excerpt_en ?: $this->excerpt_es)
            : ($this->excerpt_es ?: $this->excerpt_en);
    }

    public function body(?string $locale = null): string
    {
        $locale ??= App::getLocale();

        $body = $locale === 'en'
            ? ($this->body_en ?: $this->body_es)
            : ($this->body_es ?: $this->body_en);

        return (string) $body;
    }

    public function formattedDate(?string $locale = null): string
    {
        $locale ??= App::getLocale();
        $date = $this->published_at ?? $this->created_at;

        if (! $date) {
            return '';
        }

        return $locale === 'en'
            ? $date->translatedFormat('F j, Y')
            : $date->translatedFormat('j \d\e F \d\e Y');
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
     * @return array{id: int, title: string, image: string, href: string, category: string|null, filter2: string|null, filter3: string|null}
     */
    public function toCardItem(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title(),
            'image' => $this->imageUrl() ?? asset('images/home/section4/images/card-1.png'),
            'href' => route('pages.blog.show', $this),
            'category' => $this->category,
            'filter2' => $this->filter_secondary,
            'filter3' => $this->filter_tertiary,
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (BlogPost $post): void {
            if (filled($post->slug)) {
                return;
            }

            $base = Str::slug($post->title_es ?: $post->title_en ?: 'post');
            $slug = $base;
            $i = 2;

            while (static::query()
                ->where('slug', $slug)
                ->when($post->exists, fn (Builder $q) => $q->whereKeyNot($post->getKey()))
                ->exists()
            ) {
                $slug = $base.'-'.$i;
                $i++;
            }

            $post->slug = $slug;
        });
    }
}
