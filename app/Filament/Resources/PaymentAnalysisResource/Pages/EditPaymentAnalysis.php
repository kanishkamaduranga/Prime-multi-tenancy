<?php

namespace App\Filament\Resources\PaymentAnalysisResource\Pages;

use App\Filament\Resources\PaymentAnalysisResource;
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
