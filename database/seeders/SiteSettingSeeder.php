<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Support\Cms\CmsDefaults;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'email' => __('site.settings.email', [], 'es'),
            'phone' => __('site.settings.phone', [], 'es'),
            'whatsapp' => __('site.settings.whatsapp', [], 'es'),
            'instagram' => __('site.settings.instagram', [], 'es'),
            'facebook' => __('site.settings.facebook', [], 'es'),
            'youtube' => __('site.settings.youtube', [], 'es'),
            'linkedin' => __('site.settings.linkedin', [], 'es'),
            'es' => [
                'address' => __('site.settings.address', [], 'es'),
            ],
            'en' => [
                'address' => __('site.settings.address', [], 'en'),
            ],
        ];

        $existing = SiteSetting::query()->find(1);

        SiteSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'cms_enabled' => $existing?->cms_enabled ?? false,
                'data' => CmsDefaults::merge(
                    $defaults,
                    is_array($existing?->data) ? $existing->data : [],
                ),
            ],
        );
    }
}
