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
        return $this->belongsTo(LedgerController::class, 'control_account_id')
            ->where('type', 'control_account');
    }


    // Auto-generate creditors number before creating the record
    protected static function boot()
    {
        parent::boot();

        // Generate creditors_number after the record is created
        static::created(function ($creditor) {
            $creditor->updateCreditorsNumber();
        });
    }

    /**
     * Update the creditors_number based on the record's ID.
     */
    public function updateCreditorsNumber()
    {
        $this->creditors_number = 'SUPH' . str_pad($this->id, 8, '0', STR_PAD_LEFT);
        $this->save(); // Save the updated creditors_number
    }
}
