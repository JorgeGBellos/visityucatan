<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class ManageAlliesPage extends ManagePageContent
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Página Aliados';

    protected static ?string $title = 'Página Aliados';

    protected static ?string $slug = 'pagina-aliados';

    public static function pageKey(): string
    {
        return 'allies';
    }

    protected function cmsHelperText(): string
    {
        return 'Activa para que /aliados tome el copy de cabecera de este panel. El listado viene del CRUD Aliados.';
    }

    protected function localeFields(string $locale): array
    {
        return [
            Section::make('Cabecera')
                ->schema([
                    FileUpload::make("content.{$locale}.hero.image")
                        ->label('Ilustración de cabecera')
                        ->image()
                        ->disk('public')
                        ->directory("cms/allies-page/{$locale}")
                        ->visibility('public'),
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
                    'title' => __('site.allies_page.title', [], 'es'),
                    'subtitle' => __('site.allies_page.subtitle', [], 'es'),
                    'image' => 'images/svg/doblesilla.svg',
                ],
            ],
            'en' => [
                'hero' => [
                    'title' => __('site.allies_page.title', [], 'en'),
                    'subtitle' => __('site.allies_page.subtitle', [], 'en'),
                    'image' => 'images/svg/doblesilla.svg',
                ],
            ],
        ];
    }
}
