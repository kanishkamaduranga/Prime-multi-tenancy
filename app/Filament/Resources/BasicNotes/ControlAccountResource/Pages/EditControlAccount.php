<?php

namespace App\Filament\Resources\BasicNotes\ControlAccountResource\Pages;

use App\Filament\Resources\BasicNotes\ControlAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditControlAccount extends EditRecord
{
    protected static string $resource = ControlAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
