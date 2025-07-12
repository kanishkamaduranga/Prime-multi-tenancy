<?php

namespace App\Filament\Resources\BasicNotes\JournalResource\Pages;

use App\Filament\Resources\BasicNotes\JournalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJournal extends EditRecord
{
    protected static string $resource = JournalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
