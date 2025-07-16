<?php

namespace App\Filament\Resources\BasicNotes\ControlAccountItemResource\Pages;

use App\Filament\Resources\BasicNotes\ControlAccountItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListControlAccountItems extends ListRecords
{
    protected static string $resource = ControlAccountItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
