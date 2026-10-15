<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use App\Support\Cms\CmsDefaults;
use App\Support\Cms\SiteSettings;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * @property-read Schema $form
 */
class ManageGeneralSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Configuración';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'General';

    protected static ?string $title = 'Configuración general';

    protected static ?string $slug = 'configuracion-general';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $record = SiteSetting::current();

        $this->form->fill([
            'cms_enabled' => $record->cms_enabled,
            'data' => CmsDefaults::merge(
                $this->defaults(),
                is_array($record->data) ? $record->data : [],
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
                    ->description('Si está desconectado, el sitio usa los valores por defecto definidos en lang.')
                    ->schema([
                        Toggle::make('cms_enabled')
                            ->label('Conectar configuración al frontend')
                            ->helperText('Activa para que correo, teléfono y redes tomen estos valores en todo el sitio.')
                            ->inline(false),
                    ]),

                Section::make('Contacto')
                    ->schema([
                        TextInput::make('data.email')
                            ->label('Correo electrónico')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('data.phone')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(60)
                            ->helperText('Se muestra en el sitio y se usa para el enlace tel:'),
                        TextInput::make('data.whatsapp')
                            ->label('WhatsApp (URL)')
                            ->url()
                            ->maxLength(255)
                            ->helperText('Ej. https://wa.me/529991112233'),
                    ])
                    ->columns(2),

                Section::make('Redes sociales')
                    ->schema([
                        TextInput::make('data.instagram')->label('Instagram')->url()->maxLength(255),
                        TextInput::make('data.facebook')->label('Facebook')->url()->maxLength(255),
                        TextInput::make('data.youtube')->label('YouTube')->url()->maxLength(255),
                        TextInput::make('data.tiktok')->label('TikTok')->url()->maxLength(255),
                        TextInput::make('data.linkedin')->label('LinkedIn')->url()->maxLength(255),
                    ])
                    ->columns(2),

                Tabs::make('Locales')
                    ->tabs([
                        Tab::make('Español')
                            ->schema([
                                Textarea::make('data.es.address')
                                    ->label('Dirección')
                                    ->rows(3),
                            ]),
                        Tab::make('English')
                            ->schema([
                                Textarea::make('data.en.address')
                                    ->label('Address')
                                    ->rows(3),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $record = SiteSetting::current();
        $record->update([
            'cms_enabled' => (bool) ($state['cms_enabled'] ?? false),
            'data' => $state['data'] ?? [],
        ]);

        SiteSettings::forget();

        Notification::make()
            ->title('Configuración guardada')
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

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'email' => __('site.settings.email', [], 'es'),
            'phone' => __('site.settings.phone', [], 'es'),
            'whatsapp' => __('site.settings.whatsapp', [], 'es'),
            'instagram' => __('site.settings.instagram', [], 'es'),
            'facebook' => __('site.settings.facebook', [], 'es'),
            'youtube' => __('site.settings.youtube', [], 'es'),
            'tiktok' => __('site.settings.tiktok', [], 'es'),
            'linkedin' => __('site.settings.linkedin', [], 'es'),
            'es' => [
                'address' => __('site.settings.address', [], 'es'),
            ],
            'en' => [
                'address' => __('site.settings.address', [], 'en'),
            ],
        ];
    }
}
