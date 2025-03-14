<?php

namespace App\Filament\Resources\DeratmentResource\Pages;

use App\Filament\Resources\DeratmentResource;
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
