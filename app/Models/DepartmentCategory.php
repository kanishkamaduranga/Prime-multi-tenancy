<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DepartmentCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'department_category_number',
        'department_category_name',
    ];

    // Relationship to Department
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
