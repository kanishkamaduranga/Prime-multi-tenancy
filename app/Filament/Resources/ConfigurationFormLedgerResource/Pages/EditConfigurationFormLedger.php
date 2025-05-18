<?php

namespace App\Filament\Resources\ConfigurationFormLedgerResource\Pages;

use App\Filament\Resources\ConfigurationFormLedgerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConfigurationFormLedger extends EditRecord
{
    protected static string $resource = ConfigurationFormLedgerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
