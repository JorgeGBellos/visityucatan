<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class ManageApoyosPage extends ManagePageContent
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentArrowDown;

    protected static ?int $navigationSort = 11;

    protected static ?string $navigationLabel = 'Apoyos';

    protected static ?string $title = 'Apoyos';

    protected static ?string $slug = 'apoyos';

    public static function pageKey(): string
    {
        return 'apoyos';
    }

    protected function cmsHelperText(): string
    {
        return 'Activa para que /apoyos use los textos y el PDF de este panel. Iconos y fotos de las tarjetas son fijos. Si no subes un PDF, se descarga el bidding book del idioma.';
    }

    protected function localeFields(string $locale): array
    {
        return [
            Section::make('Descarga')
                ->schema([
                    FileUpload::make("content.{$locale}.bidding_book")
                        ->label('Bidding book (PDF)')
                        ->acceptedFileTypes(['application/pdf'])
                        ->disk('public')
                        ->directory("cms/apoyos/{$locale}")
                        ->visibility('public')
                        ->downloadable()
                        ->maxSize(20480),
                    TextInput::make("content.{$locale}.download.cta")->label('Texto del botón')->maxLength(120),
                    TextInput::make("content.{$locale}.request.cta")->label('Texto de solicitar información')->maxLength(120),
                ]),

            Section::make('Programa de patrocinios')
                ->collapsed()
                ->schema([
                    TextInput::make("content.{$locale}.program.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.program.text")->label('Texto')->rows(3),
                    Repeater::make("content.{$locale}.items")
                        ->label('Tarjetas')
                        ->helperText('El orden, el color y la foto siguen el diseño actual.')
                        ->schema([
                            TextInput::make('title')->label('Título')->required()->maxLength(255),
                            Textarea::make('description')->label('Descripción')->rows(3)->required(),
                        ])
                        ->maxItems(6)
                        ->minItems(6)
                        ->reorderable(false)
                        ->addable(false)
                        ->deletable(false)
                        ->collapsed()
                        ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
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
            'download' => [
                'cta' => __('site.apoyos_page.download_cta', [], $locale),
            ],
            'request' => [
                'cta' => __('site.apoyos_page.request_info_cta', [], $locale),
            ],
            'program' => [
                'title' => __('site.apoyos_page.program_title', [], $locale),
                'text' => __('site.apoyos_page.program_text', [], $locale),
            ],
            'items' => collect(__('site.apoyos_page.items', [], $locale))
                ->map(fn (array $item) => [
                    'title' => $item['title'] ?? '',
                    'description' => $item['description'] ?? '',
                ])
                ->values()
                ->all(),
        ];
    }
}
