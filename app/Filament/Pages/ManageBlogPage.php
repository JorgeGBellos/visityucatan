<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class ManageBlogPage extends ManagePageContent
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static ?int $navigationSort = 9;

    protected static ?string $navigationLabel = 'Página Blog';

    protected static ?string $title = 'Página Blog';

    protected static ?string $slug = 'pagina-blog';

    public static function pageKey(): string
    {
        return 'blog';
    }

    protected function cmsHelperText(): string
    {
        return 'Activa para que /blog use el hero de este panel. Los artículos salen del CRUD Blog.';
    }

    protected function localeFields(string $locale): array
    {
        return [
            Section::make('Hero')
                ->schema([
                    FileUpload::make("content.{$locale}.hero.image")
                        ->label('Ilustración')
                        ->image()
                        ->disk('public')
                        ->directory("cms/blog/{$locale}/hero")
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
                    'title' => __('site.blog_page.title', [], 'es'),
                    'subtitle' => __('site.blog_page.subtitle', [], 'es'),
                    'image' => 'images/svg/doblesilla.svg',
                ],
            ],
            'en' => [
                'hero' => [
                    'title' => __('site.blog_page.title', [], 'en'),
                    'subtitle' => __('site.blog_page.subtitle', [], 'en'),
                    'image' => 'images/svg/doblesilla.svg',
                ],
            ],
        ];
    }
}
