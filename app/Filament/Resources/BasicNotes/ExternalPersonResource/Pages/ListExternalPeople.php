<?php

namespace App\Filament\Resources\BasicNotes\ExternalPersonResource\Pages;

use App\Filament\Resources\BasicNotes\ExternalPersonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExternalPeople extends ListRecords
{
    protected static string $resource = ExternalPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
