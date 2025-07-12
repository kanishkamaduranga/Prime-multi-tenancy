<?php

namespace App\Filament\Resources\BasicNotes\CreditorResource\Pages;

use App\Filament\Resources\BasicNotes\CreditorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCreditor extends EditRecord
{
    protected static string $resource = CreditorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
