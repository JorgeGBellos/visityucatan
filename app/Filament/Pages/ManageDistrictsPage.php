<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class ManageDistrictsPage extends ManagePageContent
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'Página Distritos';

    protected static ?string $title = 'Página Distritos';

    protected static ?string $slug = 'pagina-distritos';

    public static function pageKey(): string
    {
        return 'districts';
    }

    protected function cmsHelperText(): string
    {
        return 'Activa para que /distritos use el título y subtítulo de este panel. Las cards enlazan a Distrito Centro y Distrito Norte.';
    }

    protected function localeFields(string $locale): array
    {
        return [
            Section::make('Cabecera')
                ->schema([
                    TextInput::make("content.{$locale}.hero.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.hero.subtitle")->label('Subtítulo')->rows(3),
                ]),
        ];
    }

    protected function localizedDefaults(): array
    {
        return [
            'es' => [
                'hero' => [
                    'title' => __('site.districts_page.title', [], 'es'),
                    'subtitle' => __('site.districts_page.subtitle', [], 'es'),
                ],
            ],
            'en' => [
                'hero' => [
                    'title' => __('site.districts_page.title', [], 'en'),
                    'subtitle' => __('site.districts_page.subtitle', [], 'en'),
                ],
            ],
        ];
    }
}
