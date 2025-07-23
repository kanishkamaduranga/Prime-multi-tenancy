<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class ChequePrintPreview extends Widget
{
    protected static string $view = 'filament.widgets.cheque-print-preview';

    public ?Model $record = null;
}
