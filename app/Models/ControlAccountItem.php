<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ControlAccountItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'ledger_control_account_id',
        'item_type',
        'item_number',
        'note',
    ];

    public function controlAccount()
    {
        return $this->belongsTo(LedgerController::class, 'ledger_control_account_id');
    }
}
