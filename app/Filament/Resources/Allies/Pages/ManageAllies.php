<?php

namespace App\Filament\Resources\Allies\Pages;

use App\Filament\Resources\Allies\AllyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAllies extends ManageRecords
{
    protected static string $resource = AllyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
