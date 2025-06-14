<?php

namespace App\Filament\Resources\BasicNotes\DeratmentResource\Pages;

use App\Filament\Resources\BasicNotes\DeratmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeratment extends EditRecord
{
    protected static string $resource = DeratmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
