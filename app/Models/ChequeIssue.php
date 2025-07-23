<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequeIssue extends Model
{
    use HasFactory;

    protected $table = 'cheque_issues';

    protected $fillable = [
        'reference_table',
        'reference_id',
        'cheque_number',
        'note_cheque_number_issue',
        'cheque_number_issue_by',
        'check_number_issued_time',
        'cooperative_stamp',
        'valid_date',
        'permissions',
        'need_to_signature',
        'cheque_issue_by',
        'cheque_issue_time',
        'cheque_printed_time',
    ];

    protected $casts = [
        'need_to_signature' => 'json',
    ];

    public function chequeNumberIssueBy()
    {
        return $this->belongsTo(User::class, 'cheque_number_issue_by');
    }

    public function chequeIssueBy()
    {
        return $this->belongsTo(User::class, 'cheque_issue_by');
    }
}
