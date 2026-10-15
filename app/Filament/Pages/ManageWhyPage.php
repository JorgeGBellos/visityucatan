<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class ManageWhyPage extends ManagePageContent
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMap;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Por qué Yucatán';

    protected static ?string $title = 'Por qué Yucatán';

    protected static ?string $slug = 'por-que-yucatan';

    public static function pageKey(): string
    {
        return 'why';
    }

    protected function cmsHelperText(): string
    {
        return 'Activa para que /por-que-yucatan use los textos de este panel. Los logos de aliados salen del CRUD Aliados.';
    }

    protected function localeFields(string $locale): array
    {
        $dir = "cms/why/{$locale}";

        return [
            Section::make('Hero (video)')
                ->schema([
                    Textarea::make("content.{$locale}.hero.title")
                        ->label('Título')
                        ->rows(2)
                        ->helperText('Puedes usar saltos de línea.'),
                ]),

            Section::make('Conectividad aérea')
                ->collapsed()
                ->schema([
                    TextInput::make("content.{$locale}.air.eyebrow")->label('Eyebrow')->maxLength(120),
                    TextInput::make("content.{$locale}.air.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.air.text")->label('Texto')->rows(3),
                    TagsInput::make("content.{$locale}.air.cities_left")->label('Ciudades (columna izq.)'),
                    TagsInput::make("content.{$locale}.air.cities_right")->label('Ciudades (columna der.)'),
                ]),

            Section::make('Conectividad terrestre')
                ->collapsed()
                ->schema([
                    TextInput::make("content.{$locale}.land.eyebrow")->label('Eyebrow')->maxLength(120),
                    TextInput::make("content.{$locale}.land.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.land.text")->label('Texto 1')->rows(3),
                    Textarea::make("content.{$locale}.land.text_2")->label('Texto 2')->rows(3),
                ]),

            Section::make('Atractivos')
                ->collapsed()
                ->schema([
                    TextInput::make("content.{$locale}.attractions.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.attractions.text")->label('Texto')->rows(3),
                    TextInput::make("content.{$locale}.attractions.cta")->label('CTA')->maxLength(120),
                    Repeater::make("content.{$locale}.attractions.items")
                        ->label('Cards')
                        ->schema([
                            TextInput::make('name')->label('Nombre')->required()->maxLength(255),
                        ])
                        ->collapsed()
                        ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                        ->maxItems(6),
                ]),

            Section::make('Haciendas')
                ->collapsed()
                ->schema([
                    TextInput::make("content.{$locale}.haciendas.eyebrow")->label('Eyebrow')->maxLength(120),
                    TextInput::make("content.{$locale}.haciendas.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.haciendas.text")->label('Texto')->rows(3),
                    TextInput::make("content.{$locale}.haciendas.cta")->label('CTA')->maxLength(120),
                    Repeater::make("content.{$locale}.haciendas.items")
                        ->label('Cards')
                        ->schema([
                            FileUpload::make('image')->label('Imagen')->image()->disk('public')->directory("{$dir}/haciendas")->visibility('public'),
                            TextInput::make('name')->label('Nombre')->required()->maxLength(255),
                        ])
                        ->collapsed()
                        ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                        ->maxItems(8),
                ]),

            Section::make('Venues')
                ->collapsed()
                ->schema([
                    TextInput::make("content.{$locale}.venues.eyebrow")->label('Eyebrow')->maxLength(120),
                    TextInput::make("content.{$locale}.venues.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.venues.text")->label('Texto')->rows(3),
                    TextInput::make("content.{$locale}.venues.cta")->label('CTA')->maxLength(120),
                    Repeater::make("content.{$locale}.venues.items")
                        ->label('Cards')
                        ->schema([
                            FileUpload::make('image')->label('Imagen')->image()->disk('public')->directory("{$dir}/venues")->visibility('public'),
                            TextInput::make('name')->label('Nombre')->required()->maxLength(255),
                        ])
                        ->collapsed()
                        ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                        ->maxItems(8),
                ]),

            Section::make('Sabores')
                ->collapsed()
                ->schema([
                    TextInput::make("content.{$locale}.sabores.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.sabores.text")->label('Texto')->rows(4),
                    TextInput::make("content.{$locale}.sabores.cta")->label('CTA')->maxLength(120),
                ]),

            Section::make('Cultura maya')
                ->collapsed()
                ->schema([
                    TextInput::make("content.{$locale}.cultura.eyebrow")->label('Eyebrow')->maxLength(120),
                    TextInput::make("content.{$locale}.cultura.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.cultura.text")->label('Texto 1')->rows(3),
                    Textarea::make("content.{$locale}.cultura.text_2")->label('Texto 2')->rows(3),
                    TextInput::make("content.{$locale}.cultura.cta")->label('CTA')->maxLength(120),
                ]),

            Section::make('Hospitalidad / Aliados')
                ->collapsed()
                ->description('El listado de logos viene del CRUD Aliados.')
                ->schema([
                    TextInput::make("content.{$locale}.aliados.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.aliados.text")->label('Texto')->rows(3),
                    TextInput::make("content.{$locale}.aliados.cta")->label('CTA')->maxLength(120),
                ]),

            Section::make('Banner del footer')
                ->collapsed()
                ->schema([
                    TextInput::make("content.{$locale}.footer.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.footer.text")->label('Texto')->rows(3),
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
            'hero' => [
                'title' => __('site.why_page.hero_title', [], $locale),
            ],
            'air' => [
                'eyebrow' => __('site.why_page.air_eyebrow', [], $locale),
                'title' => __('site.why_page.air_title', [], $locale),
                'text' => __('site.why_page.air_text', [], $locale),
                'cities_left' => __('site.why_page.air_cities_left', [], $locale),
                'cities_right' => __('site.why_page.air_cities_right', [], $locale),
            ],
            'land' => [
                'eyebrow' => __('site.why_page.land_eyebrow', [], $locale),
                'title' => __('site.why_page.land_title', [], $locale),
                'text' => __('site.why_page.land_text', [], $locale),
                'text_2' => __('site.why_page.land_text_2', [], $locale),
            ],
            'attractions' => [
                'title' => __('site.why_page.attractions_title', [], $locale),
                'text' => __('site.why_page.attractions_text', [], $locale),
                'cta' => __('site.why_page.attractions_cta', [], $locale),
                'items' => collect(__('site.why_page.attractions', [], $locale))
                    ->values()
                    ->map(fn (array $item) => ['name' => $item['name'] ?? ''])
                    ->all(),
            ],
            'haciendas' => [
                'eyebrow' => __('site.why_page.haciendas_eyebrow', [], $locale),
                'title' => __('site.why_page.haciendas_title', [], $locale),
                'text' => __('site.why_page.haciendas_text', [], $locale),
                'cta' => __('site.why_page.haciendas_cta', [], $locale),
                'items' => collect(__('site.why_page.haciendas', [], $locale))
                    ->values()
                    ->map(function (array $item, int $index) {
                        return [
                            'name' => $item['name'] ?? '',
                            'image' => $item['image'] ?? 'images/why-yucatan/grid/Image Placeholder ('.(11 + (($index + 2) % 6)).').png',
                        ];
                    })
                    ->all(),
            ],
            'venues' => [
                'eyebrow' => __('site.why_page.venues_eyebrow', [], $locale),
                'title' => __('site.why_page.venues_title', [], $locale),
                'text' => __('site.why_page.venues_text', [], $locale),
                'cta' => __('site.why_page.venues_cta', [], $locale),
                'items' => collect(__('site.why_page.venues', [], $locale))
                    ->values()
                    ->map(function (array $item, int $index) {
                        return [
                            'name' => $item['name'] ?? '',
                            'image' => $item['image'] ?? 'images/why-yucatan/grid/Image Placeholder ('.(11 + ($index % 6)).').png',
                        ];
                    })
                    ->all(),
            ],
            'sabores' => [
                'title' => __('site.why_page.sabores_title', [], $locale),
                'text' => __('site.why_page.sabores_text', [], $locale),
                'cta' => __('site.why_page.sabores_cta', [], $locale),
            ],
            'cultura' => [
                'eyebrow' => __('site.why_page.cultura_eyebrow', [], $locale),
                'title' => __('site.why_page.cultura_title', [], $locale),
                'text' => __('site.why_page.cultura_text', [], $locale),
                'text_2' => __('site.why_page.cultura_text_2', [], $locale),
                'cta' => __('site.why_page.cultura_cta', [], $locale),
            ],
            'aliados' => [
                'title' => __('site.why_page.aliados_title', [], $locale),
                'text' => __('site.why_page.aliados_text', [], $locale),
                'cta' => __('site.why_page.aliados_cta', [], $locale),
            ],
            'footer' => [
                'title' => __('site.why_page.footer_hero_title', [], $locale),
                'text' => __('site.why_page.footer_hero_text', [], $locale),
            ],
        ];
    }
}
