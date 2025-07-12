<?php

namespace App\Filament\Resources\BasicNotes\BranchTypeResource\Pages;

use App\Filament\Resources\BasicNotes\BranchTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBranchType extends EditRecord
{
    protected static string $resource = BranchTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
