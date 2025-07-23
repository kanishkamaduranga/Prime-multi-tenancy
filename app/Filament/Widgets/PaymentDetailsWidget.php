<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class PaymentDetailsWidget extends Widget
{
    protected static string $view = 'filament.widgets.payment-details-widget';

    public ?Model $record = null;
}
