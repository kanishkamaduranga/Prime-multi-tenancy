<?php

namespace App\Filament\Resources\ConfigurationFormLedgerResource\Pages;

use App\Filament\Resources\ConfigurationFormLedgerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConfigurationFormLedgers extends ListRecords
{
    protected static string $resource = ConfigurationFormLedgerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
