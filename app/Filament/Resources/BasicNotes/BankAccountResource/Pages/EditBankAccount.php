<?php

namespace App\Filament\Resources\BasicNotes\BankAccountResource\Pages;

use App\Filament\Resources\BasicNotes\BankAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBankAccount extends EditRecord
{
    protected static string $resource = BankAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
