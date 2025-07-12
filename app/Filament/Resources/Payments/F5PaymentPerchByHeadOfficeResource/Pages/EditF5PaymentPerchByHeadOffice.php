<?php

namespace App\Filament\Resources\Payments\F5PaymentPerchByHeadOfficeResource\Pages;

use App\Filament\Resources\Payments\F5PaymentPerchByHeadOfficeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditF5PaymentPerchByHeadOffice extends EditRecord
{
    protected static string $resource = F5PaymentPerchByHeadOfficeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterFill(): void
    {
        // Eager load payment details with place relationship
        $this->form->fill([
            'total_amount' => number_format($this->record->paymentDetails->sum('price'), 2)
        ]);
    }
}
