<?php

namespace App\Filament\Resources\BasicNotes\DebtorResource\Pages;

use App\Filament\Resources\BasicNotes\DebtorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDebtors extends ListRecords
{
    protected static string $resource = DebtorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
