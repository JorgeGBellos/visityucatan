<?php

namespace App\Filament\Resources\DistrictPlaces;

use App\Filament\Resources\DistrictPlaces\Pages\ManageDistrictPlaces;
use App\Models\DirectoryFilter;
use App\Models\District;
use App\Models\DistrictPlace;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use UnitEnum;

class DistrictPlaceResource extends Resource
{
    protected static ?string $model = DistrictPlace::class;

    protected static ?string $recordTitleAttribute = 'title_es';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|UnitEnum|null $navigationGroup = 'Contenido dinámico';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Espacios de distrito';

    protected static ?string $modelLabel = 'espacio';

    protected static ?string $pluralModelLabel = 'espacios de distrito';

    protected static ?string $slug = 'espacios-distrito';

    /**
     * @return array<string, string>
     */
    public static function categoryOptions(): array
    {
        return [
            'hotels' => 'Haciendas',
            'venues' => 'Venues',
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Asociación')
                    ->schema([
                        Select::make('district_id')
                            ->label('Distrito')
                            ->relationship(
                                name: 'district',
                                titleAttribute: 'title_es',
                                modifyQueryUsing: fn ($query) => $query->ordered(),
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText('Define si el espacio aparece en CIC o Siglo XXI.'),
                        Select::make('category')
                            ->label('Categoría (tab)')
                            ->options(static::categoryOptions())
                            ->required(),
                        Select::make('type')
                            ->label('Filtro 1 — Tipo')
                            ->options(fn (): array => DirectoryFilter::optionsForGroup(DirectoryFilter::GROUP_TYPE))
                            ->searchable(),
                        Select::make('filter_secondary')
                            ->label('Filtro 2 — Zona')
                            ->options(fn (): array => DirectoryFilter::optionsForGroup(DirectoryFilter::GROUP_SECONDARY))
                            ->searchable(),
                        Select::make('filter_tertiary')
                            ->label('Filtro 3 — Capacidad')
                            ->options(fn (): array => DirectoryFilter::optionsForGroup(DirectoryFilter::GROUP_TERTIARY))
                            ->searchable(),
                    ])
                    ->columns(2),

                Tabs::make('Locales')
                    ->tabs([
                        Tab::make('Español')
                            ->schema([
                                TextInput::make('title_es')
                                    ->label('Título')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description_es')
                                    ->label('Descripción')
                                    ->rows(3),
                            ]),
                        Tab::make('English')
                            ->schema([
                                TextInput::make('title_en')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description_en')
                                    ->label('Description')
                                    ->rows(3),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Medios y datos')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Imagen')
                            ->image()
                            ->disk('public')
                            ->directory('cms/district-places')
                            ->visibility('public'),
                        TextInput::make('website_url')
                            ->label('Sitio web')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Teléfono / redes')
                            ->maxLength(120),
                        TextInput::make('location')
                            ->label('Ubicación')
                            ->maxLength(255),
                        TextInput::make('sort_order')
                            ->label('Orden')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_published')
                            ->label('Publicado')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Imagen')
                    ->disk('public')
                    ->square(),
                TextColumn::make('title_es')
                    ->label('Título (ES)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('district.title_es')
                    ->label('Distrito')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category')
                    ->label('Categoría')
                    ->formatStateUsing(fn (?string $state): string => static::categoryOptions()[$state] ?? ($state ?? ''))
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Orden')
                    ->sortable(),
                IconColumn::make('is_published')
                    ->label('Publicado')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                SelectFilter::make('district_id')
                    ->label('Distrito')
                    ->options(fn (): array => District::query()->ordered()->pluck('title_es', 'id')->all()),
                SelectFilter::make('category')
                    ->label('Categoría')
                    ->options(static::categoryOptions()),
                TernaryFilter::make('is_published')
                    ->label('Publicado'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageDistrictPlaces::route('/'),
        ];
    }
}
