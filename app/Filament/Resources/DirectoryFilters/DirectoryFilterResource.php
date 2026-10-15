<?php

namespace App\Filament\Resources\DirectoryFilters;

use App\Filament\Resources\DirectoryFilters\Pages\ManageDirectoryFilters;
use App\Models\DirectoryFilter;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use UnitEnum;

class DirectoryFilterResource extends Resource
{
    protected static ?string $model = DirectoryFilter::class;

    protected static ?string $recordTitleAttribute = 'title_es';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFunnel;

    protected static string|UnitEnum|null $navigationGroup = 'Contenido dinámico';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Filtros de directorio';

    protected static ?string $modelLabel = 'filtro';

    protected static ?string $pluralModelLabel = 'filtros de directorio';

    protected static ?string $slug = 'filtros-directorio';

    /**
     * @return array<string, string>
     */
    public static function groupOptions(): array
    {
        return [
            DirectoryFilter::GROUP_TYPE => 'Filtro 1 — Tipo',
            DirectoryFilter::GROUP_SECONDARY => 'Filtro 2 — Zona',
            DirectoryFilter::GROUP_TERTIARY => 'Filtro 3 — Capacidad',
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Filtro')
                    ->schema([
                        Select::make('group')
                            ->label('Grupo')
                            ->options(static::groupOptions())
                            ->required()
                            ->helperText('Define en qué select del directorio aparece esta opción.'),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(120)
                            ->helperText('Identificador interno, ej. centro, boutique.'),
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group')
                    ->label('Grupo')
                    ->formatStateUsing(fn (?string $state): string => static::groupOptions()[$state] ?? ($state ?? ''))
                    ->sortable(),
                TextColumn::make('title_es')
                    ->label('Título (ES)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                TextColumn::make('sort_order')
                    ->label('Orden')
                    ->sortable(),
                IconColumn::make('is_published')
                    ->label('Publicado')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                SelectFilter::make('group')
                    ->label('Grupo')
                    ->options(static::groupOptions()),
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
            'index' => ManageDirectoryFilters::route('/'),
        ];
    }
}
