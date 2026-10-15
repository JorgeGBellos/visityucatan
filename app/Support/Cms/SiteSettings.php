<?php

namespace App\Support\Cms;

use App\Models\SiteSetting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class SiteSettings
{
    public function __construct(
        protected SiteSetting $settings,
        protected ?string $locale = null,
    ) {
        $this->locale ??= App::getLocale();
    }

    public static function make(): self
    {
        $settings = Cache::remember(
            'cms.site_settings',
            now()->addMinutes(5),
            fn () => SiteSetting::current(),
        );

        return new self($settings);
    }

    public static function forget(): void
    {
        Cache::forget('cms.site_settings');
    }

    public function enabled(): bool
    {
        return (bool) $this->settings->cms_enabled;
    }

    public function get(string $path, ?string $fallbackTranslationKey = null, mixed $default = null): mixed
    {
        if ($this->enabled()) {
            $value = Arr::get($this->settings->data ?? [], $path);

            if (filled($value)) {
                return $value;
            }
        }

        if (filled($fallbackTranslationKey)) {
            return __($fallbackTranslationKey);
        }

        return $default;
    }

    public function localized(string $path, ?string $fallbackTranslationKey = null, mixed $default = null): mixed
    {
        if ($this->enabled()) {
            $value = Arr::get($this->settings->data ?? [], "{$this->locale}.{$path}")
                ?? Arr::get($this->settings->data ?? [], ($this->locale === 'en' ? 'es' : 'en').".{$path}");

            if (filled($value)) {
                return $value;
            }
        }

        if (filled($fallbackTranslationKey)) {
            return __($fallbackTranslationKey);
        }

        return $default;
    }

    public function email(): string
    {
        return (string) $this->get('email', 'site.settings.email');
    }

    public function phone(): string
    {
        return (string) $this->get('phone', 'site.settings.phone');
    }

    public function phoneHref(): string
    {
        $phone = preg_replace('/[^\d+]/', '', $this->phone()) ?: '';

        return $phone !== '' ? 'tel:'.$phone : '#';
    }

    public function emailHref(): string
    {
        $email = $this->email();

        return filled($email) ? 'mailto:'.$email : '#';
    }

    public function whatsapp(): string
    {
        return (string) $this->get('whatsapp', 'site.settings.whatsapp');
    }

    public function instagram(): string
    {
        return (string) $this->get('instagram', 'site.settings.instagram');
    }

    public function facebook(): string
    {
        return (string) $this->get('facebook', 'site.settings.facebook');
    }

    public function youtube(): string
    {
        return (string) $this->get('youtube', 'site.settings.youtube');
    }

    public function tiktok(): string
    {
        return (string) $this->get('tiktok', 'site.settings.tiktok');
    }

    public function linkedin(): string
    {
        return (string) $this->get('linkedin', 'site.settings.linkedin');
    }

    public function address(): string
    {
        return (string) $this->localized('address', 'site.settings.address');
    }

    /**
     * @return list<array{label: string, href: string, icon: string}>
     */
    public function socials(): array
    {
        return [
            [
                'label' => 'WhatsApp',
                'href' => $this->whatsapp() ?: '#',
                'icon' => 'images/svg/whatsapp.svg',
            ],
            [
                'label' => 'Instagram',
                'href' => $this->instagram() ?: '#',
                'icon' => 'images/svg/instagram.svg',
            ],
            [
                'label' => 'Facebook',
                'href' => $this->facebook() ?: '#',
                'icon' => 'images/footer/facebook.svg',
            ],
            [
                'label' => 'TikTok',
                'href' => $this->tiktok() ?: '#',
                'icon' => 'images/footer/tiktok.svg',
            ],
            [
                'label' => 'LinkedIn',
                'href' => $this->linkedin() ?: '#',
                'icon' => 'images/footer/linkedin.svg',
            ],
        ];
    }
}
