<?php

namespace App\Filament\Resources\BasicNotes\ControlAccountItemResource\Pages;

use App\Filament\Resources\BasicNotes\ControlAccountItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditControlAccountItem extends EditRecord
{
    protected static string $resource = ControlAccountItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
