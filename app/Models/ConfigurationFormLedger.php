<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigurationFormLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'configuration_type',
        'department_id',
        'debit_ledger_id',
        'credit_ledger_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function debitLedger()
    {
        return $this->belongsTo(Ledger::class, 'debit_ledger_id');
    }

    public function creditLedger()
    {
        return $this->belongsTo(Ledger::class, 'credit_ledger_id');
    }
}
