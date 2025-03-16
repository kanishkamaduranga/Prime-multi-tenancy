<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Debtor extends Model
{
    use HasFactory;

    protected $fillable = [
        'debtor_number',
        'customer_number',
        'debtor_name',
        'address',
        'telephone_number',
        'control_account_id',
        'saved_amount',
        'date',
    ];

    // Relationship to ControlAccount
    public function controlAccount(): BelongsTo
    {
        return $this->belongsTo(ControlAccount::class, 'control_account_id');
    }

    // Auto-generate debtor_number after the model is created
    protected static function boot()
    {
        parent::boot();

        static::created(function ($debtor) {
            // Generate a unique debtor number based on the ID
            $debtor->debtor_number = 'D' . str_pad($debtor->id, 5, '0', STR_PAD_LEFT);
            $debtor->save(); // Save the model again to update the debtor_number
        });
    }
}
