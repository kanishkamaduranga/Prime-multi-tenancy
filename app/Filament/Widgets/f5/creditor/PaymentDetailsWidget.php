<?php

namespace App\Filament\Widgets\f5\creditor;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class PaymentDetailsWidget extends Widget
{
    protected static string $view = 'filament.widgets.f5.creditor.payment-details-widget';

    public ?Model $record = null;
}
