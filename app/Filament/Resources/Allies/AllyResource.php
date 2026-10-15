<?php

namespace App\Filament\Resources\Allies;

use App\Filament\Resources\Allies\Pages\ManageAllies;
use App\Models\Ally;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
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
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use UnitEnum;

class AllyResource extends Resource
{
    protected static ?string $model = Ally::class;

    protected static ?string $recordTitleAttribute = 'title_es';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Contenido dinámico';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Aliados';

    protected static ?string $modelLabel = 'aliado';

    protected static ?string $pluralModelLabel = 'aliados';

    protected static ?string $slug = 'aliados';

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
                            ->directory('cms/allies')
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
                        TextInput::make('category')
                            ->label('Categoría')
                            ->maxLength(120)
                            ->helperText('Usada para filtros del directorio.'),
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
                TextColumn::make('category')
                    ->label('Categoría')
                    ->toggleable()
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
            'index' => ManageAllies::route('/'),
        ];
    }
}
