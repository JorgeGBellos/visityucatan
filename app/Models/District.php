<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;

class District extends Model
{
    protected $fillable = [
        'slug',
        'title_es',
        'title_en',
        'image',
        'href',
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

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function places(): HasMany
    {
        return $this->hasMany(DistrictPlace::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function title(?string $locale = null): string
    {
        $locale ??= App::getLocale();

        return $locale === 'en'
            ? ($this->title_en ?: $this->title_es)
            : ($this->title_es ?: $this->title_en);
    }

    public function pageKey(): string
    {
        return match ($this->slug) {
            'siglo-xxi' => 'distrito_siglo_xxi',
            default => 'distrito_cic',
        };
    }

    public function langKey(): string
    {
        return match ($this->slug) {
            'siglo-xxi' => 'site.distrito_siglo_xxi',
            default => 'site.distrito_cic',
        };
    }
}
