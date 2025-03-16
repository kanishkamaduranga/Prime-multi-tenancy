<?php

namespace App\Filament\Resources\VehiclesRentedResource\Pages;

use App\Filament\Resources\VehiclesRentedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVehiclesRented extends EditRecord
{
    protected static string $resource = VehiclesRentedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
