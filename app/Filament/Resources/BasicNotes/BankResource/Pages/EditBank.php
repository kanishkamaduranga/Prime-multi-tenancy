<?php

namespace App\Filament\Resources\BasicNotes\BankResource\Pages;

use App\Filament\Resources\BasicNotes\BankResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBank extends EditRecord
{
    protected static string $resource = BankResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
