<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class F5PaymentPerchByHeadOffice extends Model
{
    use HasFactory;

    protected $table = 'f5_payment_perches_by_head_office';

    protected $fillable = [
        'voucher_number',
        'cooppen_number',
        'department_id',
        'supplier_id',
        'bank_account_id',
        'cheque_receiver',
        'summary',
        'payment_type',
        'payment_analysis',
        'created_by',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Creditor::class, 'supplier_id');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function paymentDetails()
    {
        return $this->hasMany(F5PaymentDetail::class, 'reference_id')
            ->where('reference_table', 'head_office');
    }

    public function getReferenceTable(): string
    {
        return 'head_office'; // Unique identifier for this form
    }

    public function getTotalAmountAttribute()
    {
        return $this->paymentDetails->sum('price');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate voucher number
            $latest = static::latest()->first();
            $increment = $latest ? (int) explode('HO', $latest->voucher_number)[1] + 1 : 1;
            $model->voucher_number = 'F05' . date('y') . 'HO' . str_pad($increment, 5, '0', STR_PAD_LEFT);

            // Set created by
            $model->created_by = auth()->id();
        });
    }
}
