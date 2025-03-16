<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BranchType extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'branch_type_number',
        'branch_type_name',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
