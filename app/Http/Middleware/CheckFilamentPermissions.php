<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;


class CheckFilamentPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        \Log::info("CheckFilamentPermissions  " ,[
            'path' => $request->path(),
            'route' => $request->route()->getName()
        ] );

        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        if ($user->hasRole('Super Admin')) {
            // Clear permission cache
            app()[PermissionRegistrar::class]->forgetCachedPermissions();

            // Get all permissions if not already assigned
            if (!$user->hasAllPermissions(Permission::all())) {
                $user->givePermissionTo(Permission::all());
            }
            return $next($request);
        }

        $route = $request->route();
        $name = $request->route()->getName();
        $routeName = $request->route()->getName();
        // Check if this is a Filament route
        if (str_contains($name, 'filament.')) {
            $resource = explode('.', $name)[4] ?? null;
            $action = explode('.', $name)[5] ?? null;

            if ($resource && $action) {

                $permission = str_replace(' ', '', ucwords(str_replace('-', ' ', $resource))) . "_" . ($action == 'index' ? 'view' : $action);

                \Log::info("CheckFilamentPermissions  " ,[
                    'resource' => $resource,
                    'action' => $action,
                    'permission' => $permission,
                ] );

                if('Pages_dashboard' != $permission) {
                    if (!auth()->user()->can($permission)) {

                        \Log::info("Permission denied", [
                            'user_id' => $user->id,
                            'permission' => $permission,
                            'route' => $routeName
                        ]);
                        return redirect()
                            ->route('filament.admin.pages.dashboard')
                            ->with('error', 'You do not have permission to access this page.');
                    }
                }
            }
        }

        return $next($request);
    }
}
