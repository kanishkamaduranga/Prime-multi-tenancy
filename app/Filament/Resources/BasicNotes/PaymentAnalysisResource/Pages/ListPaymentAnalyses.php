<?php

namespace App\Filament\Resources\BasicNotes\PaymentAnalysisResource\Pages;

use App\Filament\Resources\BasicNotes\PaymentAnalysisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaymentAnalyses extends ListRecords
{
    protected static string $resource = PaymentAnalysisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
