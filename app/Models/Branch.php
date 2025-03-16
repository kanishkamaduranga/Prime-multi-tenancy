<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'region_id',
        'branch_type_id',
        'branch_code',
        'branch_name',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function branchType()
    {
        return $this->belongsTo(BranchType::class);
    }

    // Many-to-Many Relationship to Managers
    public function managers(): BelongsToMany
    {
        return $this->belongsToMany(Manager::class, 'branch_manager')
            ->using(BranchManager::class)
            ->withTimestamps();
    }
}
