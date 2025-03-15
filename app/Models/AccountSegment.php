<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AccountSegment extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'basic_account',
        'account_number',
        'account_name',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
