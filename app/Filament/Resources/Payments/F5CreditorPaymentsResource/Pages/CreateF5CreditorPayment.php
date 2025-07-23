<?php

namespace App\Filament\Resources\Payments\F5CreditorPaymentsResource\Pages;

use App\Filament\Resources\Payments\F5CreditorPaymentsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateF5CreditorPayment extends CreateRecord
{
    protected static string $resource = F5CreditorPaymentsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['payment_created_by'] = auth()->id();
        $data['voucher_number'] = 'V' . time(); // temporary voucher number
        return $data;
    }
}
