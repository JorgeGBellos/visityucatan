<?php

namespace App\Filament\Resources\DirectoryFilters\Pages;

use App\Filament\Resources\DirectoryFilters\DirectoryFilterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageDirectoryFilters extends ManageRecords
{
    protected static string $resource = DirectoryFilterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
