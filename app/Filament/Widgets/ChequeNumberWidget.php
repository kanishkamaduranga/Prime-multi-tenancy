<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class ChequeNumberWidget extends Widget
{
    protected static string $view = 'filament.widgets.cheque-number-widget';

    public ?Model $record = null;
}
