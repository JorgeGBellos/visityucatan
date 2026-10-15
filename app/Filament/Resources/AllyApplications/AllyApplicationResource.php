<?php

namespace App\Filament\Resources\AllyApplications;

use App\Filament\Resources\AllyApplications\Pages\ManageAllyApplications;
use App\Models\AllyApplication;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class AllyApplicationResource extends Resource
{
    protected static ?string $model = AllyApplication::class;

    protected static ?string $recordTitleAttribute = 'business_name';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|UnitEnum|null $navigationGroup = 'Contenido dinámico';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Solicitudes de aliados';

    protected static ?string $modelLabel = 'solicitud';

    protected static ?string $pluralModelLabel = 'solicitudes de aliados';

    protected static ?string $slug = 'solicitudes-aliados';

    public static function getNavigationBadge(): ?string
    {
        $count = AllyApplication::query()->pending()->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos de la solicitud')
                    ->schema([
                        TextInput::make('business_name')
                            ->label('Nombre del negocio')
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('business_type')
                            ->label('Tipo de negocio')
                            ->disabled()
                            ->dehydrated(false),
                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(4)
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),
                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('website')
                            ->label('Página web')
                            ->disabled()
                            ->dehydrated(false),
                        FileUpload::make('photos')
                            ->label('Fotos')
                            ->image()
                            ->multiple()
                            ->disk('public')
                            ->directory('ally-applications')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Gestión interna')
                    ->schema([
                        Select::make('status')
                            ->label('Estado')
                            ->options(AllyApplication::statusOptions())
                            ->required(),
                        Textarea::make('admin_notes')
                            ->label('Notas internas')
                            ->rows(4)
                            ->helperText('Solo visibles en el panel; no se muestran al solicitante.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('business_name')
                    ->label('Negocio')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('business_type')
                    ->label('Tipo')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->toggleable(),
                TextColumn::make('website')
                    ->label('Web')
                    ->limit(30)
                    ->url(fn (AllyApplication $record): string => str_starts_with($record->website, 'http') ? $record->website : 'https://'.$record->website, shouldOpenInNewTab: true)
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => AllyApplication::statusOptions()[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        AllyApplication::STATUS_PENDING => 'warning',
                        AllyApplication::STATUS_REVIEWED => 'success',
                        AllyApplication::STATUS_ARCHIVED => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Recibida')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options(AllyApplication::statusOptions()),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Revisar'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAllyApplications::route('/'),
        ];
    }
}
