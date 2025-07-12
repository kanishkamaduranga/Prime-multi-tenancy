<?php

namespace App\Filament\Resources\BasicNotes\LedgerResource\Pages;

use App\Filament\Resources\BasicNotes\LedgerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLedgers extends ListRecords
{
    protected static string $resource = LedgerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
