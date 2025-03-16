<?php

namespace App\Filament\Resources\SubAccountSegmentResource\Pages;

use App\Filament\Resources\SubAccountSegmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubAccountSegments extends ListRecords
{
    protected static string $resource = SubAccountSegmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
