<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExternalPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'customer_number',
        'name',
        'address',
        'nic_number',
        'telephone_number',
    ];
}
