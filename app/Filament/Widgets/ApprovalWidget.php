<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class ApprovalWidget extends Widget
{
    protected static string $view = 'filament.widgets.approval-widget';

    public ?Model $record = null;
}
