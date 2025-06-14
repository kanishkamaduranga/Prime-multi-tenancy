<?php

namespace App\Filament\Resources\BasicNotes\EmployeeResource\Pages;

use App\Filament\Resources\BasicNotes\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
