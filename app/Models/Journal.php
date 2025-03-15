<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'journal_number',
        'journal',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
