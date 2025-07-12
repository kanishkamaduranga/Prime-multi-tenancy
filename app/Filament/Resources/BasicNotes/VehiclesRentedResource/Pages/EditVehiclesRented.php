<?php

namespace App\Filament\Resources\BasicNotes\VehiclesRentedResource\Pages;

use App\Filament\Resources\BasicNotes\VehiclesRentedResource;
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
