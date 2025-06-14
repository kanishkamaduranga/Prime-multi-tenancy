<?php

namespace App\Filament\Resources\BasicNotes\ControlAccountResource\Pages;

use App\Filament\Resources\BasicNotes\ControlAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListControlAccounts extends ListRecords
{
    protected static string $resource = ControlAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
