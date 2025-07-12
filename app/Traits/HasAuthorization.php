<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

trait HasAuthorization
{
    public static function can(string $action, ?Model $record = null): bool
    {

        /*if (auth()->user()?->hasRole('Super Admin')) {
            Log::channel('authorization')->debug('Super Admin access granted', [
                'user_id' => auth()->id(),
                'action' => $action,
                'model' => class_basename(static::getModel())
            ]);
            return true;
        }*/

        $permission = "{$action} ".static::getPermissionKey();

        return auth()->user()?->can($permission);
    }
}
