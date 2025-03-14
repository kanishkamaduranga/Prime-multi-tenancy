<?php

namespace App\Filament\Resources\DeratmentResource\Pages;

use App\Filament\Resources\DeratmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeratments extends ListRecords
{
    protected static string $resource = DeratmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
