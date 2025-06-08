<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class F5PaymentDetail extends Model
{
    use HasFactory;

    protected $table = 'f5_payment_details';

    protected $fillable = [
        'reference_id',
        'reference_table',
        'details',
        'price',
        'place_id',
    ];

    public function place()
    {
        return $this->belongsTo(Branch::class, 'place_id');
    }
}
