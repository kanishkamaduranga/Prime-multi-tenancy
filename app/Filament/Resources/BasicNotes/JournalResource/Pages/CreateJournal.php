<?php

namespace App\Filament\Resources\BasicNotes\JournalResource\Pages;

use App\Filament\Resources\BasicNotes\JournalResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJournal extends CreateRecord
{
    protected static string $resource = JournalResource::class;
}
