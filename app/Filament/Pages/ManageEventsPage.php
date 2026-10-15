<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class ManageEventsPage extends ManagePageContent
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationLabel = 'Página Eventos';

    protected static ?string $title = 'Página Eventos';

    protected static ?string $slug = 'pagina-eventos';

    public static function pageKey(): string
    {
        return 'events';
    }

    protected function cmsHelperText(): string
    {
        return 'Activa para que /eventos use el banner e intro de este panel. Los eventos salen del CRUD Eventos.';
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
                ]),

            Section::make('Intro')
                ->schema([
                    Textarea::make("content.{$locale}.intro")
                        ->label('Texto introductorio')
                        ->rows(3),
                ]),
        ];
    }

    protected function localizedDefaults(): array
    {
        return [
            'es' => [
                'banner' => [
                    'title' => __('site.events_page.banner_title', [], 'es'),
                ],
                'intro' => __('site.events_page.intro', [], 'es'),
            ],
            'en' => [
                'banner' => [
                    'title' => __('site.events_page.banner_title', [], 'en'),
                ],
                'intro' => __('site.events_page.intro', [], 'en'),
            ],
        ];
    }
}
