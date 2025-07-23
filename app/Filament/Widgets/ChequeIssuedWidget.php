<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class ChequeIssuedWidget extends Widget
{
    protected static string $view = 'filament.widgets.cheque-issued-widget';

    public ?Model $record = null;
}
