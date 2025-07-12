<?php

namespace App\Filament\Resources\Users\ConfigurationFormLedgerResource\Pages;

use App\Filament\Resources\Users\ConfigurationFormLedgerResource;
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
