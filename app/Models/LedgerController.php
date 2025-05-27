<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerController extends Model
{
    use HasFactory;

    protected $table = 'ledger_controllers';

    protected $fillable = [
        'type',
        'department_id',
        'basic_account',
        'account_segment_id',
        'sub_account_segment_id',
        'number',
        'name',
        'control_account_id',
        'basic_ledger',
        'f8_number',
    ];

    protected $casts = [
        'basic_ledger' => 'json',
        'f8_number' => 'boolean',
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
        return $this->belongsTo(self::class, 'control_account_id');
    }

    public function ledgers()
    {
        return $this->hasMany(self::class, 'control_account_id')->where('type', 'ledger');
    }

    public function scopeControlAccounts($query)
    {
        return $query->where('type', 'control_account');
    }

    public function scopeLedgers($query)
    {
        return $query->where('type', 'ledger');
    }
}

