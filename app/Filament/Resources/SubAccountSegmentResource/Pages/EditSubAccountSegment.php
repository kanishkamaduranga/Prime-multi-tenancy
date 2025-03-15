<?php

namespace App\Filament\Resources\SubAccountSegmentResource\Pages;

use App\Filament\Resources\SubAccountSegmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubAccountSegment extends EditRecord
{
    protected static string $resource = SubAccountSegmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
