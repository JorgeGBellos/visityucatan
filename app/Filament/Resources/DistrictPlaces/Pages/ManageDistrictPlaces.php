<?php

namespace App\Filament\Resources\DistrictPlaces\Pages;

use App\Filament\Resources\DistrictPlaces\DistrictPlaceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageDistrictPlaces extends ManageRecords
{
    protected static string $resource = DistrictPlaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
