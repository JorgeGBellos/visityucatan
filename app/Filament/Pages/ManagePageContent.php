<?php

namespace App\Filament\Pages;

use App\Models\PageContent;
use App\Support\Cms\Cms;
use App\Support\Cms\CmsDefaults;
use Filament\Actions\Action;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use UnitEnum;

/**
 * @property-read Schema $form
 */
abstract class ManagePageContent extends Page
{
    protected static string|UnitEnum|null $navigationGroup = 'Páginas';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    abstract public static function pageKey(): string;

    abstract protected function cmsHelperText(): string;

    /**
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    abstract protected function localeFields(string $locale): array;

    /**
     * @return array<string, mixed>
     */
    abstract protected function localizedDefaults(): array;

    public function mount(): void
    {
        $record = PageContent::key(static::pageKey());

        $this->form->fill([
            'cms_enabled' => $record->cms_enabled,
            'content' => CmsDefaults::merge(
                $this->localizedDefaults(),
                is_array($record->content) ? $record->content : [],
            ),
        ]);
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema
            ->operation('edit')
            ->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('CMS')
                    ->description('Si está desconectado, el frontend usa los textos e imágenes por defecto del código / lang.')
                    ->schema([
                        Toggle::make('cms_enabled')
                            ->label('Conectar CMS al frontend')
                            ->helperText($this->cmsHelperText())
                            ->inline(false),
                    ]),

                Tabs::make('Locales')
                    ->tabs([
                        Tab::make('Español')
                            ->schema($this->localeFields('es')),
                        Tab::make('English')
                            ->schema($this->localeFields('en')),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $key = static::pageKey();

        $record = PageContent::key($key);
        $record->update([
            'cms_enabled' => (bool) ($data['cms_enabled'] ?? false),
            'content' => $data['content'] ?? [],
            'label' => static::$title ?? $key,
        ]);

        Cms::forget($key);

        Notification::make()
            ->title((static::$title ?? 'Página').' guardada')
            ->success()
            ->send();
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Guardar')
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ]),
                    ]),
            ]);
    }
}
