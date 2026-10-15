<?php

namespace App\Filament\Resources\BlogPosts;

use App\Filament\Resources\BlogPosts\Pages\ManageBlogPosts;
use App\Models\BlogPost;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $recordTitleAttribute = 'title_es';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static string|UnitEnum|null $navigationGroup = 'Contenido dinámico';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Blog';

    protected static ?string $modelLabel = 'artículo';

    protected static ?string $pluralModelLabel = 'artículos';

    protected static ?string $slug = 'blog';

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
                                Textarea::make('excerpt_es')
                                    ->label('Extracto')
                                    ->rows(3),
                                RichEditor::make('body_es')
                                    ->label('Contenido')
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('English')
                            ->schema([
                                TextInput::make('title_en')
                                    ->label('Title')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('excerpt_en')
                                    ->label('Excerpt')
                                    ->rows(3),
                                RichEditor::make('body_en')
                                    ->label('Content')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Publicación')
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->helperText('Se genera automáticamente si se deja vacío.'),
                        TextInput::make('author')
                            ->label('Autor')
                            ->maxLength(120),
                        DateTimePicker::make('published_at')
                            ->label('Fecha de publicación')
                            ->native(false)
                            ->seconds(false),
                        FileUpload::make('image')
                            ->label('Imagen principal')
                            ->image()
                            ->disk('public')
                            ->directory('cms/blog')
                            ->visibility('public'),
                        TextInput::make('category')
                            ->label('Categoría')
                            ->maxLength(120),
                        TextInput::make('filter_secondary')
                            ->label('Filtro secundario')
                            ->maxLength(120),
                        TextInput::make('filter_tertiary')
                            ->label('Filtro terciario')
                            ->maxLength(120),
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
                    ->disk('public'),
                TextColumn::make('title_es')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('author')
                    ->label('Autor')
                    ->toggleable(),
                TextColumn::make('published_at')
                    ->label('Publicación')
                    ->date()
                    ->sortable(),
                TextColumn::make('category')
                    ->label('Categoría')
                    ->badge()
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
            'index' => ManageBlogPosts::route('/'),
        ];
    }
}
