<?php

namespace App\Filament\Resources\AccountSegmentResource\Pages;

use App\Filament\Resources\AccountSegmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccountSegment extends EditRecord
{
    protected static string $resource = AccountSegmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
