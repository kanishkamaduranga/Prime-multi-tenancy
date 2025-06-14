<?php

namespace App\Filament\Resources\BasicNotes\LedgerResource\Pages;

use App\Filament\Resources\BasicNotes\LedgerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLedger extends EditRecord
{
    protected static string $resource = LedgerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
