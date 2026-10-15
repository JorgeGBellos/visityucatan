<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class DistrictPlace extends Model
{
    public const CATEGORIES = [
        'hotels',
        'venues',
    ];

    protected $fillable = [
        'district_id',
        'category',
        'type',
        'filter_secondary',
        'filter_tertiary',
        'title_es',
        'title_en',
        'description_es',
        'description_en',
        'image',
        'phone',
        'website_url',
        'location',
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

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeForDistrict(Builder $query, District|int $district): Builder
    {
        $id = $district instanceof District ? $district->id : $district;

        return $query->where('district_id', $id);
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

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://') || str_starts_with($this->image, '/')) {
            return $this->image;
        }

        if (Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        return asset($this->image);
    }

    /**
     * @return array{id: int, category: string, type: string|null, filter2: string|null, filter3: string|null, label: string, name: string, description: string, phone: string, website: string, location: string, image: string, href: string}
     */
    public function toDirectoryItem(): array
    {
        $labelKey = $this->type ?: $this->category;
        $label = __('site.distrito_directory.labels.'.$labelKey);
        if (! is_string($label) || $label === 'site.distrito_directory.labels.'.$labelKey) {
            $label = __('site.distrito_directory.labels.'.$this->category);
        }
        [$websiteDisplay, $href] = $this->websiteParts();

        return [
            'id' => $this->id,
            'category' => $this->category,
            'type' => $this->type,
            'filter2' => $this->filter_secondary,
            'filter3' => $this->filter_tertiary,
            'label' => is_string($label) ? $label : $this->category,
            'name' => $this->title(),
            'description' => $this->description() ?? '',
            'phone' => $this->localizeContactValue($this->phone ?? ''),
            'website' => $this->localizeContactValue($websiteDisplay),
            'location' => $this->localizeContactValue($this->location ?? ''),
            'image' => $this->imageUrl() ?? asset('images/home/section4/images/card-1.png'),
            'href' => $href,
        ];
    }

    protected function localizeContactValue(string $value): string
    {
        $normalized = mb_strtolower(trim($value));

        return match ($normalized) {
            'página web', 'pagina web' => __('site.distrito_directory.website_placeholder'),
            'correo' => __('site.distrito_directory.email_placeholder'),
            'telefono', 'teléfono' => __('site.distrito_directory.phone_placeholder'),
            default => $value,
        };
    }

    /**
     * @return array{0: string, 1: string}
     */
    protected function websiteParts(): array
    {
        $raw = trim((string) ($this->website_url ?? ''));

        if ($raw === '') {
            return ['', '#'];
        }

        $normalized = mb_strtolower($raw);
        if (in_array($normalized, ['página web', 'pagina web'], true)) {
            return [__('site.distrito_directory.website_placeholder'), '#'];
        }

        if (filter_var($raw, FILTER_VALIDATE_URL)) {
            $host = parse_url($raw, PHP_URL_HOST) ?: $raw;

            return [preg_replace('/^www\./', '', $host) ?: $host, $raw];
        }

        if (preg_match('/^[a-z0-9.-]+\.[a-z]{2,}(?:\/.*)?$/i', $raw) === 1) {
            return [$raw, 'https://'.$raw];
        }

        return [$raw, '#'];
    }
}
