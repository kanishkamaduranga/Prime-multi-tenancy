<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Manager extends Model
{
    use HasFactory;

    protected $fillable = [
        'manager_number',
        'manager_name',
        'control_account_id',
        'department_id',
        'branch_type_id',
        'status'
    ];


    public function controlAccount(): BelongsTo
    {
        return $this->belongsTo(LedgerController::class, 'control_account_id')
            ->where('type', 'control_account');
    }

    // Relationship to Department
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // Relationship to BranchType
    public function branchType(): BelongsTo
    {
        return $this->belongsTo(BranchType::class, 'branch_type_id');
    }

    // Many-to-Many Relationship to Branches
    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'branch_manager')
            ->using(BranchManager::class)
            ->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($manager) {
            // Generate a 4-digit number with leading zeros based on the ID
            $manager->manager_number = str_pad($manager->id, 4, '0', STR_PAD_LEFT);
            $manager->save(); // Save the model again to update the manager_number
        });
    }

}
