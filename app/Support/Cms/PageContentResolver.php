<?php

namespace App\Support\Cms;

use App\Models\PageContent;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class PageContentResolver
{
    public function __construct(
        protected PageContent $page,
        protected ?string $locale = null,
    ) {
        $this->locale ??= App::getLocale();
    }

    public function enabled(): bool
    {
        return (bool) $this->page->cms_enabled;
    }

    public function page(): PageContent
    {
        return $this->page;
    }

    /**
     * Resolve a localized content path. Falls back to translation key or raw default.
     */
    public function text(string $path, ?string $fallbackTranslationKey = null, mixed $default = null): mixed
    {
        if ($this->enabled()) {
            $value = Arr::get($this->page->content ?? [], "{$this->locale}.{$path}");

            if (filled($value)) {
                return $value;
            }

            $otherLocale = $this->locale === 'en' ? 'es' : 'en';
            $fallbackValue = Arr::get($this->page->content ?? [], "{$otherLocale}.{$path}");

            if (filled($fallbackValue)) {
                return $fallbackValue;
            }
        }

        if (filled($fallbackTranslationKey)) {
            return __($fallbackTranslationKey);
        }

        return $default;
    }

    /**
     * Resolve an image path for use with asset()/Storage.
     * CMS uploads are stored on the public disk; fallbacks are public/ paths.
     */
    public function image(string $path, string $fallbackPublicPath): string
    {
        if ($this->enabled()) {
            $value = Arr::get($this->page->content ?? [], "{$this->locale}.{$path}")
                ?? Arr::get($this->page->content ?? [], 'es.'.$path)
                ?? Arr::get($this->page->content ?? [], 'en.'.$path);

            if (filled($value)) {
                if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://') || str_starts_with($value, '/')) {
                    return $value;
                }

                if (Storage::disk('public')->exists($value)) {
                    return Storage::disk('public')->url($value);
                }

                return asset($value);
            }
        }

        return asset($fallbackPublicPath);
    }

    /**
     * @return list<mixed>
     */
    public function list(string $path, array $fallback = []): array
    {
        if ($this->enabled()) {
            $value = Arr::get($this->page->content ?? [], "{$this->locale}.{$path}");

            if (is_array($value) && $value !== []) {
                return array_values($value);
            }
        }

        return $fallback;
    }

    /**
     * Resolve a stored media path (CMS upload or public asset) to a URL.
     */
    public function mediaUrl(?string $path, ?string $fallbackPublicPath = null): ?string
    {
        if (filled($path)) {
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/storage/')) {
                return $path;
            }

            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->url($path);
            }

            return asset($path);
        }

        return filled($fallbackPublicPath) ? asset($fallbackPublicPath) : null;
    }
}
