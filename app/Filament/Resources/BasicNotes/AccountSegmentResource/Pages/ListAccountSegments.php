<?php

namespace App\Filament\Resources\BasicNotes\AccountSegmentResource\Pages;

use App\Filament\Resources\BasicNotes\AccountSegmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccountSegments extends ListRecords
{
    protected static string $resource = AccountSegmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
