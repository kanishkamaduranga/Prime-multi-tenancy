<?php

namespace App\Filament\Resources\Payments\F5PaymentPerchByHeadOfficeResource\Pages;

use App\Filament\Resources\Payments\F5PaymentPerchByHeadOfficeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListF5PaymentPerchByHeadOffices extends ListRecords
{
    protected static string $resource = F5PaymentPerchByHeadOfficeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
