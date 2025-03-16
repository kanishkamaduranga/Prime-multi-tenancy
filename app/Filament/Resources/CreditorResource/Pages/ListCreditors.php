<?php

namespace App\Filament\Resources\CreditorResource\Pages;

use App\Filament\Resources\CreditorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCreditors extends ListRecords
{
    protected static string $resource = CreditorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
