<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubAccountSegment extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'basic_account',
        'account_segment_id',
        'sub_account_number',
        'sub_account_name',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function accountSegment()
    {
        return $this->belongsTo(AccountSegment::class);
    }
}
