<?php

namespace App\Filament\Resources\BasicNotes\RegionResource\Pages;

use App\Filament\Resources\BasicNotes\RegionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRegion extends EditRecord
{
    protected static string $resource = RegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
