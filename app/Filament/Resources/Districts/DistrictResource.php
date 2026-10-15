<?php

namespace App\Filament\Resources\Districts;

use App\Filament\Resources\Districts\Pages\ManageDistricts;
use App\Models\District;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
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
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use UnitEnum;

class DistrictResource extends Resource
{
    protected static ?string $model = District::class;

    protected static ?string $recordTitleAttribute = 'title_es';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static string|UnitEnum|null $navigationGroup = 'Contenido dinámico';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Distritos';

    protected static ?string $modelLabel = 'distrito';

    protected static ?string $pluralModelLabel = 'distritos';

    protected static ?string $slug = 'distritos';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Locales')
                    ->tabs([
                        Tab::make('Español')
                            ->schema([
                                TextInput::make('title_es')
                                    ->label('Título')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Tab::make('English')
                            ->schema([
                                TextInput::make('title_en')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Medios y enlace')
                    ->schema([
                        Select::make('slug')
                            ->label('Slug')
                            ->options([
                                'cic' => 'cic',
                                'siglo-xxi' => 'siglo-xxi',
                            ])
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Define la URL /distrito/{slug}.'),
                        FileUpload::make('image')
                            ->label('Imagen')
                            ->image()
                            ->disk('public')
                            ->directory('cms/districts')
                            ->visibility('public'),
                        TextInput::make('href')
                            ->label('URL / ruta')
                            ->helperText('Ej. /distrito/cic o /distrito/siglo-xxi.')
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
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('href')
                    ->label('Enlace')
                    ->toggleable(),
                TextColumn::make('sort_order')
                    ->label('Orden')
                    ->sortable(),
                IconColumn::make('is_published')
                    ->label('Publicado')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
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
            'index' => ManageDistricts::route('/'),
        ];
    }
}
