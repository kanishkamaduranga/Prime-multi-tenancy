<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class F5CreditorPayment extends Model
{
    use HasFactory;

    protected $table = 'f5_creditor_payments';

    protected $fillable = [
        'voucher_number',
        'coupon_number',
        'department_id',
        'supplier_id',
        'date_of_paid',
        'bank_account_id',
        'cheque_receiver',
        'note',
        'total_amount',
        'payment_type',
        'payment_created_by',
        'status',
        'note_approved_or_rejected',
        'approved_or_rejected_by',
        'approved_or_rejected_time',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Creditor::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function paymentCreatedBy()
    {
        return $this->belongsTo(User::class, 'payment_created_by');
    }

    public function approvedOrRejectedBy()
    {
        return $this->belongsTo(User::class, 'approved_or_rejected_by');
    }

    public function paymentDetails()
    {
        return $this->hasMany(F5PaymentDetail::class, 'reference_id')->where('reference_table', 'f5_creditor_payments');
    }

    public function chequeIssue()
    {
        return $this->hasOne(ChequeIssue::class, 'reference_id')->where('reference_table', 'f5_creditor_payments');
    }
}
