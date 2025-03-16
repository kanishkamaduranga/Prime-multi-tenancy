<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creditor extends Model
{
    use HasFactory;

    protected $fillable = [
        'creditors_number',
        'customer_number',
        'creditor_name',
        'address',
        'telephone_number',
        'control_account_id',
        'price',
        'year',
        'month',
    ];

    public function controlAccount()
    {
        return $this->belongsTo(ControlAccount::class);
    }

    // Auto-generate creditors number before creating the record
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($creditor) {
            $creditor->creditors_number = 'SUPH' . str_pad($creditor->id, 8, '0', STR_PAD_LEFT);
        });
    }
}
