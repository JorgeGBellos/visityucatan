<?php

namespace App\Filament\Resources\Events;

use App\Filament\Resources\Events\Pages\ManageEvents;
use App\Models\Event;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
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

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $recordTitleAttribute = 'title_es';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|UnitEnum|null $navigationGroup = 'Contenido dinámico';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Eventos';

    protected static ?string $modelLabel = 'evento';

    protected static ?string $pluralModelLabel = 'eventos';

    protected static ?string $slug = 'eventos';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Locales')
                    ->tabs([
                        Tab::make('Español')
                            ->schema([
                                TextInput::make('title_es')->label('Título')->required()->maxLength(255),
                                TextInput::make('category_es')->label('Categoría')->maxLength(120),
                                TextInput::make('date_label_es')->label('Fecha (texto)')->maxLength(255),
                                TextInput::make('location_es')->label('Ubicación')->maxLength(255),
                            ]),
                        Tab::make('English')
                            ->schema([
                                TextInput::make('title_en')->label('Title')->required()->maxLength(255),
                                TextInput::make('category_en')->label('Category')->maxLength(120),
                                TextInput::make('date_label_en')->label('Date (text)')->maxLength(255),
                                TextInput::make('location_en')->label('Location')->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Publicación')
                    ->schema([
                        TextInput::make('slug')->label('Slug')->maxLength(255),
                        FileUpload::make('image')
                            ->label('Imagen')
                            ->image()
                            ->disk('public')
                            ->directory('cms/events')
                            ->visibility('public'),
                        DatePicker::make('starts_at')->label('Fecha de inicio')->native(false),
                        TextInput::make('sort_order')->label('Orden')->numeric()->default(0)->required(),
                        Toggle::make('is_published')->label('Publicado')->default(true)->inline(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('Imagen')->disk('public'),
                TextColumn::make('title_es')->label('Título')->searchable()->sortable(),
                TextColumn::make('category_es')->label('Categoría')->badge(),
                TextColumn::make('starts_at')->label('Inicio')->date()->sortable(),
                TextColumn::make('sort_order')->label('Orden')->sortable(),
                IconColumn::make('is_published')->label('Publicado')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                TernaryFilter::make('is_published')->label('Publicado'),
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
            'index' => ManageEvents::route('/'),
        ];
    }
}
