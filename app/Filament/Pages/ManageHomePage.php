<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class ManageHomePage extends ManagePageContent
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Homepage';

    protected static ?string $title = 'Homepage';

    protected static ?string $slug = 'homepage';

    public static function pageKey(): string
    {
        return 'home';
    }

    protected function cmsHelperText(): string
    {
        return 'Activa para que la homepage use estos textos. Solo incluye secciones que existen hoy en el frontend.';
    }

    protected function localeFields(string $locale): array
    {
        $dir = "cms/home/{$locale}";

        return [
            Section::make('Hero')
                ->schema([
                    Textarea::make("content.{$locale}.hero.title")
                        ->label('Título')
                        ->rows(2)
                        ->helperText('Puedes usar saltos de línea.'),
                ]),

            Section::make('Destino')
                ->collapsed()
                ->description('Banda de cifras bajo el hero. Los iconos son fijos.')
                ->schema([
                    TextInput::make("content.{$locale}.destino.title")->label('Título')->maxLength(255),
                    Repeater::make("content.{$locale}.destino.stats")
                        ->label('Cifras')
                        ->schema([
                            TextInput::make('value')->label('Número')->required(),
                            TextInput::make('label')->label('Etiqueta')->required(),
                        ])
                        ->maxItems(10)
                        ->minItems(10)
                        ->reorderable(false)
                        ->addable(false)
                        ->deletable(false)
                        ->columns(2),
                ]),

            Section::make('Nosotros (sección 2)')
                ->collapsed()
                ->schema([
                    Textarea::make("content.{$locale}.about.text")->label('Texto 1')->rows(3),
                    Textarea::make("content.{$locale}.about.text_2")->label('Texto 2')->rows(3),
                    TextInput::make("content.{$locale}.about.cta")->label('CTA')->maxLength(120),
                ]),

            Section::make('Servicios')
                ->collapsed()
                ->schema([
                    TextInput::make("content.{$locale}.servicios.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.servicios.text")->label('Texto')->rows(3),
                    Repeater::make("content.{$locale}.servicios.items")
                        ->label('Cards')
                        ->schema([
                            FileUpload::make('image')->label('Imagen')->image()->disk('public')->directory("{$dir}/servicios")->visibility('public'),
                            FileUpload::make('icon')->label('Icono')->image()->disk('public')->directory("{$dir}/servicios/icons")->visibility('public'),
                            TextInput::make('title')->label('Título')->required(),
                            Textarea::make('description')->label('Descripción')->rows(2),
                        ])
                        ->collapsed()
                        ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                        ->defaultItems(6)
                        ->maxItems(6),
                ]),

            Section::make('Programa de patrocinio')
                ->collapsed()
                ->schema([
                    TextInput::make("content.{$locale}.patrocinio.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.patrocinio.text")->label('Texto')->rows(3),
                    TextInput::make("content.{$locale}.patrocinio.cta")->label('CTA')->maxLength(120),
                    Repeater::make("content.{$locale}.patrocinio.items")
                        ->label('Apoyos')
                        ->helperText('Los iconos son los del diseño actual.')
                        ->schema([
                            TextInput::make('label')->label('Etiqueta')->required()->maxLength(120),
                        ])
                        ->maxItems(6)
                        ->minItems(6)
                        ->reorderable(false)
                        ->addable(false)
                        ->deletable(false),
                ]),

            Section::make('Distritos')
                ->collapsed()
                ->schema([
                    TextInput::make("content.{$locale}.distritos.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.distritos.text")->label('Texto')->rows(3),
                ]),

            Section::make('Aliados')
                ->collapsed()
                ->description('El listado de logos/cards viene del CRUD Aliados.')
                ->schema([
                    TextInput::make("content.{$locale}.aliados.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.aliados.text")->label('Texto')->rows(3),
                ]),

            Section::make('Presencia en medios')
                ->collapsed()
                ->schema([
                    TextInput::make("content.{$locale}.medios.title")->label('Título')->maxLength(255),
                ]),

            Section::make('Fideture')
                ->collapsed()
                ->schema([
                    TextInput::make("content.{$locale}.fideture.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.fideture.text")->label('Texto')->rows(4),
                    TextInput::make("content.{$locale}.fideture.cta")->label('CTA')->maxLength(120),
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
                'title' => __('site.home.hero_title', [], $locale),
            ],
            'destino' => [
                'title' => __('site.home.destino_stats_title', [], $locale),
                'stats' => collect(__('site.home.destino_stats', [], $locale))
                    ->map(fn (array $item) => [
                        'value' => $item['value'] ?? '',
                        'label' => $item['label'] ?? '',
                    ])
                    ->values()
                    ->all(),
            ],
            'about' => [
                'text' => __('site.home.about_text', [], $locale),
                'text_2' => __('site.home.about_text_2', [], $locale),
                'cta' => __('site.home.about_cta', [], $locale),
            ],
            'servicios' => [
                'title' => __('site.home.servicios_title', [], $locale),
                'text' => __('site.home.servicios_text', [], $locale),
                'items' => collect(__('site.home.servicios', [], $locale))
                    ->values()
                    ->map(function (array $item, int $index) {
                        $n = $index + 1;

                        return [
                            'image' => "images/home/section4/images/card-{$n}.png",
                            'icon' => "images/home/section4/icons/icon-{$n}.svg",
                            'title' => $item['title'] ?? '',
                            'description' => $item['description'] ?? '',
                        ];
                    })
                    ->all(),
            ],
            'patrocinio' => [
                'title' => __('site.home.patrocinio_title', [], $locale),
                'text' => __('site.home.patrocinio_text', [], $locale),
                'cta' => __('site.home.patrocinio_cta', [], $locale),
                'items' => collect(__('site.home.patrocinio_items', [], $locale))
                    ->map(fn (string $label) => ['label' => $label])
                    ->values()
                    ->all(),
            ],
            'distritos' => [
                'title' => __('site.home.distritos_title', [], $locale),
                'text' => __('site.home.distritos_text', [], $locale),
            ],
            'aliados' => [
                'title' => __('site.home.aliados_title', [], $locale),
                'text' => __('site.home.aliados_text', [], $locale),
            ],
            'medios' => [
                'title' => __('site.home.medios_title', [], $locale),
            ],
            'fideture' => [
                'title' => __('site.home.fideture_title', [], $locale),
                'text' => __('site.home.fideture_text', [], $locale),
                'cta' => __('site.home.fideture_cta', [], $locale),
            ],
        ];
    }
}
