<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_number',
        'customer_number',
        'employee_name',
        'address',
        'date_of_birth',
        'nic_number',
        'etf_number',
        'employee_type',
        'cashier',
    ];

    // Auto-generate employee_number after the model is created
    protected static function boot()
    {
        parent::boot();

        static::created(function ($employee) {
            // Generate a unique employee number based on the ID
            $employee->employee_number = 'EMP' . str_pad($employee->id, 5, '0', STR_PAD_LEFT);
            $employee->save(); // Save the model again to update the employee_number
        });
    }
}
