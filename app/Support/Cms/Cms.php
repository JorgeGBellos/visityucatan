<?php

namespace App\Support\Cms;

use App\Models\PageContent;
use Illuminate\Support\Facades\Cache;

class Cms
{
    public static function page(string $pageKey): PageContentResolver
    {
        $page = Cache::remember(
            "cms.page.{$pageKey}",
            now()->addMinutes(5),
            fn () => PageContent::key($pageKey),
        );

        return new PageContentResolver($page);
    }

    public static function forget(string $pageKey): void
    {
        Cache::forget("cms.page.{$pageKey}");
    }
}
