<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class ManageAboutPage extends ManagePageContent
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Nosotros';

    protected static ?string $title = 'Nosotros';

    protected static ?string $slug = 'nosotros';

    public static function pageKey(): string
    {
        return 'about';
    }

    protected function cmsHelperText(): string
    {
        return 'Activa para que /nosotros use el hero, la sección Visit, el equipo y el bloque Fideture de este panel.';
    }

    protected function localeFields(string $locale): array
    {
        $dir = "cms/about/{$locale}";

        return [
            Section::make('Hero (video)')
                ->schema([
                    Textarea::make("content.{$locale}.hero.title")
                        ->label('Título')
                        ->rows(2)
                        ->helperText('Puedes usar saltos de línea.'),
                ]),

            Section::make('Visit Yucatán')
                ->collapsed()
                ->schema([
                    TextInput::make("content.{$locale}.visit.title")->label('Título (accesible)')->maxLength(255),
                    Textarea::make("content.{$locale}.visit.text")->label('Texto 1')->rows(3),
                    Textarea::make("content.{$locale}.visit.text_2")->label('Texto 2')->rows(3),
                ]),

            Section::make('Equipo')
                ->collapsed()
                ->schema([
                    TextInput::make("content.{$locale}.team.title")->label('Título')->maxLength(255),
                    Textarea::make("content.{$locale}.team.text")->label('Texto 1')->rows(3),
                    Textarea::make("content.{$locale}.team.text_2")->label('Texto 2')->rows(2),
                    Repeater::make("content.{$locale}.team.members")
                        ->label('Miembros')
                        ->schema([
                            FileUpload::make('image')->label('Foto')->image()->disk('public')->directory("{$dir}/team")->visibility('public'),
                            TextInput::make('name')->label('Nombre')->required()->maxLength(255),
                            TextInput::make('role')->label('Cargo')->required()->maxLength(255),
                        ])
                        ->collapsed()
                        ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                        ->reorderable()
                        ->defaultItems(0),
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
                'title' => __('site.about_page.hero_title', [], $locale),
            ],
            'visit' => [
                'title' => __('site.about_page.visit_title', [], $locale),
                'text' => __('site.about_page.visit_text', [], $locale),
                'text_2' => __('site.about_page.visit_text_2', [], $locale),
            ],
            'team' => [
                'title' => __('site.about_page.team_title', [], $locale),
                'text' => __('site.about_page.team_text', [], $locale),
                'text_2' => __('site.about_page.team_text_2', [], $locale),
                'members' => collect(__('site.about_page.team_members', [], $locale))
                    ->values()
                    ->map(fn (array $member) => [
                        'name' => $member['name'] ?? '',
                        'role' => $member['role'] ?? '',
                        'image' => $member['image'] ?? null,
                    ])
                    ->all(),
            ],
            'fideture' => [
                'title' => __('site.home.fideture_title', [], $locale),
                'text' => __('site.home.fideture_text', [], $locale),
                'cta' => __('site.home.fideture_cta', [], $locale),
            ],
        ];
    }
}
