<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BranchManager extends Pivot
{
    protected $table = 'branch_manager';
}
