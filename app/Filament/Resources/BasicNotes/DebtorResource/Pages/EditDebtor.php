<?php

namespace App\Filament\Resources\BasicNotes\DebtorResource\Pages;

use App\Filament\Resources\BasicNotes\DebtorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDebtor extends EditRecord
{
    protected static string $resource = DebtorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
