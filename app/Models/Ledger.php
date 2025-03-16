<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ledger extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'basic_account',
        'account_segment_id',
        'sub_account_segment_id',
        'ledger_number',
        'ledger_name',
        'control_account_id',
        'basic_ledger',
        'f8_number',
    ];

    protected $casts = [
        'basic_ledger' => 'json', // Cast JSON field to array
        'f8_number' => 'boolean', // Cast boolean field
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

    public function controlAccount()
    {
        return $this->belongsTo(ControlAccount::class);
    }
}
