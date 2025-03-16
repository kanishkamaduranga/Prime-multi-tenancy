<?php

namespace App\Filament\Resources\BranchTypeResource\Pages;

use App\Filament\Resources\BranchTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBranchTypes extends ListRecords
{
    protected static string $resource = BranchTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
