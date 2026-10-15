<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class Ally extends Model
{
    protected $fillable = [
        'title_es',
        'title_en',
        'description_es',
        'description_en',
        'image',
        'website_url',
        'phone',
        'location',
        'category',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function scopeNewest(Builder $query): Builder
    {
        return $query->orderByDesc('created_at')->orderByDesc('id');
    }

    public function title(?string $locale = null): string
    {
        $locale ??= App::getLocale();

        return $locale === 'en'
            ? ($this->title_en ?: $this->title_es)
            : ($this->title_es ?: $this->title_en);
    }

    public function description(?string $locale = null): ?string
    {
        $locale ??= App::getLocale();

        return $locale === 'en'
            ? ($this->description_en ?: $this->description_es)
            : ($this->description_es ?: $this->description_en);
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

    public function websiteHost(): string
    {
        $url = trim((string) $this->website_url);

        if ($url === '') {
            return '';
        }

        if (! str_contains($url, '://')) {
            $url = 'https://'.$url;
        }

        $host = parse_url($url, PHP_URL_HOST);

        if (! is_string($host) || $host === '') {
            return preg_replace('#^https?://#', '', rtrim((string) $this->website_url, '/')) ?: '';
        }

        return preg_replace('/^www\./i', '', $host) ?: $host;
    }

    public function websiteHref(): string
    {
        $url = trim((string) $this->website_url);

        if ($url === '') {
            return '#';
        }

        if (! str_contains($url, '://')) {
            return 'https://'.$url;
        }

        return $url;
    }

    /**
     * @return array{id: int, type: string, label: string, name: string, description: string, phone: string, website: string, location: string, image: string, href: string, imageMode: string}
     */
    public function toDirectoryItem(): array
    {
        $category = $this->category ?: 'DMC';

        return [
            'id' => $this->id,
            'type' => $category,
            'label' => $category,
            'name' => $this->title(),
            'description' => $this->description() ?? '',
            'phone' => $this->phone ?? '',
            'website' => $this->websiteHost(),
            'location' => $this->location ?? '',
            'image' => $this->imageUrl() ?? asset('images/home/aliados/adventures-mexico.png'),
            'href' => $this->websiteHref(),
            'imageMode' => 'contain',
        ];
    }

    /**
     * @return array{name: string, description: string, phone: string, website: string, image: string, href: string}
     */
    public function toCarouselItem(): array
    {
        return [
            'name' => $this->title(),
            'description' => $this->description() ?? '',
            'phone' => $this->phone ?? '',
            'website' => $this->websiteHost(),
            'image' => $this->imageUrl() ?? asset('images/home/aliados/adventures-mexico.png'),
            'href' => $this->websiteHref(),
        ];
    }
}
