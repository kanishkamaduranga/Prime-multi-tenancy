<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ControlAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'basic_account',
        'account_segment_id',
        'sub_account_segment_id',
        'account_number',
        'account_name',
        'basic_ledger',
    ];

    protected $casts = [
        'basic_ledger' => 'array', // Cast JSON to array
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function accountSegment()
    {
        return $this->belongsTo(AccountSegment::class);
    }

    public function subAccountSegment()
    {
        return $this->belongsTo(SubAccountSegment::class);
    }
}
