<?php

namespace App\Filament\Resources\VehiclesRentedResource\Pages;

use App\Filament\Resources\VehiclesRentedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVehiclesRenteds extends ListRecords
{
    protected static string $resource = VehiclesRentedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
