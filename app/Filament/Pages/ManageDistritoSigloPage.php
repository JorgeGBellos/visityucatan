<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class ManageDistritoSigloPage extends ManagePageContent
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static ?int $navigationSort = 8;

    protected static ?string $navigationLabel = 'Distrito Norte';

    protected static ?string $title = 'Distrito Norte';

    protected static ?string $slug = 'distrito-siglo-xxi-page';

    public static function pageKey(): string
    {
        return 'distrito_siglo_xxi';
    }

    protected function cmsHelperText(): string
    {
        return 'Activa para que /distrito/siglo-xxi (Distrito Norte) use el banner e intro de este panel. Los espacios salen del CRUD Espacios de distrito.';
    }

    protected function localeFields(string $locale): array
    {
        return [
            Section::make('Banner (video)')
                ->schema([
                    Textarea::make("content.{$locale}.banner.title")
                        ->label('Título del banner')
                        ->rows(2)
                        ->helperText('Puedes usar saltos de línea.'),
                    TextInput::make("content.{$locale}.hero.title")->label('Título corto (SEO / tabs)')->maxLength(255),
                    Textarea::make("content.{$locale}.hero.subtitle")->label('Subtítulo')->rows(2),
                ]),

            Section::make('Intro')
                ->schema([
                    Textarea::make("content.{$locale}.intro.headline")->label('Titular')->rows(3),
                    TextInput::make("content.{$locale}.intro.text_before")->label('Texto antes del resaltado')->maxLength(255),
                    TextInput::make("content.{$locale}.intro.text_bold")->label('Texto resaltado (negritas)')->maxLength(255),
                    Textarea::make("content.{$locale}.intro.text_after")->label('Texto después del resaltado')->rows(3),
                    TextInput::make("content.{$locale}.intro.cta")->label('CTA')->maxLength(120),
                    TextInput::make("content.{$locale}.intro.cta_url")->label('CTA — URL')->url()->maxLength(255),
                ]),
        ];
    }

    protected function localizedDefaults(): array
    {
        return [
            'es' => $this->defaultsFor('es'),
            'en' => $this->defaultsFor('en'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultsFor(string $locale): array
    {
        return [
            'banner' => [
                'title' => __('site.distrito_siglo_xxi.banner_title', [], $locale),
            ],
            'hero' => [
                'title' => __('site.distrito_siglo_xxi.title', [], $locale),
                'subtitle' => __('site.distrito_siglo_xxi.subtitle', [], $locale),
            ],
            'intro' => [
                'headline' => __('site.distrito_siglo_xxi.intro_headline', [], $locale),
                'text_before' => __('site.distrito_siglo_xxi.intro_text_before', [], $locale),
                'text_bold' => __('site.distrito_siglo_xxi.intro_text_bold', [], $locale),
                'text_after' => __('site.distrito_siglo_xxi.intro_text_after', [], $locale),
                'cta' => __('site.distrito_siglo_xxi.cta', [], $locale),
                'cta_url' => __('site.distrito_siglo_xxi.cta_url', [], $locale),
            ],
        ];
    }
}
