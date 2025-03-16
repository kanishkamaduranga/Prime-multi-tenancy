<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehiclesRented extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'month',
        'vehicle_number',
        'payment_method',
        'price',
    ];
}
