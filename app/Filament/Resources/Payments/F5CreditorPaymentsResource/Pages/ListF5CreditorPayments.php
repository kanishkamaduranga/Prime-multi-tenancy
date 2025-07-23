<?php

namespace App\Filament\Resources\Payments\F5CreditorPaymentsResource\Pages;

use App\Filament\Resources\Payments\F5CreditorPaymentsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListF5CreditorPayments extends ListRecords
{
    protected static string $resource = F5CreditorPaymentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
