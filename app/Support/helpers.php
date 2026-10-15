<?php

use App\Support\Cms\Cms;
use App\Support\Cms\PageContentResolver;
use App\Support\Cms\SiteSettings;

if (! function_exists('cms_page')) {
    function cms_page(string $pageKey): PageContentResolver
    {
        return Cms::page($pageKey);
    }
}

if (! function_exists('site_settings')) {
    function site_settings(): SiteSettings
    {
        return SiteSettings::make();
    }
}

if (! function_exists('cms_asset')) {
    function cms_asset(?string $path, ?string $fallback = null): string
    {
        $value = filled($path) ? $path : $fallback;

        if (! filled($value)) {
            return '';
        }

        if (
            str_starts_with($value, 'http://')
            || str_starts_with($value, 'https://')
            || str_starts_with($value, '/')
        ) {
            return $value;
        }

        return asset($value);
    }
}
