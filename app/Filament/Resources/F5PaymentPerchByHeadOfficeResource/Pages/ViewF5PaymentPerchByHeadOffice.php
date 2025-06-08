<?php

namespace App\Filament\Resources\F5PaymentPerchByHeadOfficeResource\Pages;

use App\Filament\Resources\F5PaymentPerchByHeadOfficeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewF5PaymentPerchByHeadOffice extends ViewRecord
{
    protected static string $resource = F5PaymentPerchByHeadOfficeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
