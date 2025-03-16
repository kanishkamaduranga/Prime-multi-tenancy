<?php

namespace App\Filament\Resources\CreditorResource\Pages;

use App\Filament\Resources\CreditorResource;
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
