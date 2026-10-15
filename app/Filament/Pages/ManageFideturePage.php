<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class ManageFideturePage extends ManagePageContent
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Fideture';

    protected static ?string $title = 'Fideture';

    protected static ?string $slug = 'fideture';

    public static function pageKey(): string
    {
        return 'fideture';
    }

    protected function cmsHelperText(): string
    {
        return 'Activa para que /fideture use el hero de pantalla completa de este panel.';
    }

    protected function localeFields(string $locale): array
    {
        return [
            Section::make('Hero')
                ->schema([
                    FileUpload::make("content.{$locale}.hero.image")
                        ->label('Imagen de fondo')
                        ->image()
                        ->disk('public')
                        ->directory("cms/fideture/{$locale}/hero")
                        ->visibility('public'),
                    TextInput::make("content.{$locale}.hero.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.hero.text")->label('Texto')->rows(4),
                    TextInput::make("content.{$locale}.hero.cta")->label('CTA')->maxLength(120),
                    TextInput::make("content.{$locale}.hero.cta_url")->label('CTA — URL')->url()->maxLength(255),
                ]),
        ];
    }

    protected function localizedDefaults(): array
    {
        return [
            'es' => [
                'hero' => [
                    'title' => __('site.fideture_page.hero_title', [], 'es'),
                    'text' => __('site.fideture_page.hero_text', [], 'es'),
                    'cta' => __('site.fideture_page.hero_cta', [], 'es'),
                    'cta_url' => __('site.fideture_page.about_cta_url', [], 'es'),
                    'image' => 'images/home/Frame 106.png',
                ],
            ],
            'en' => [
                'hero' => [
                    'title' => __('site.fideture_page.hero_title', [], 'en'),
                    'text' => __('site.fideture_page.hero_text', [], 'en'),
                    'cta' => __('site.fideture_page.hero_cta', [], 'en'),
                    'cta_url' => __('site.fideture_page.about_cta_url', [], 'en'),
                    'image' => 'images/home/Frame 106.png',
                ],
            ],
        ];
    }
}
