<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'bank_account_number',
        'bank_account_name',
        'balance_start_date',
        'start_balance',
        'debit_or_credit',
        'department_id',
        'basic_account',
        'account_segment_id',
        'sub_account_segment_id',
        'ledger_id',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

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

    public function ledger()
    {
        return $this->belongsTo(Ledger::class);
    }
}
