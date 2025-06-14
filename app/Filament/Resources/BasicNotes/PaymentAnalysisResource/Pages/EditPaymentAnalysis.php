<?php

namespace App\Filament\Resources\BasicNotes\PaymentAnalysisResource\Pages;

use App\Filament\Resources\BasicNotes\PaymentAnalysisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentAnalysis extends EditRecord
{
    protected static string $resource = PaymentAnalysisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
