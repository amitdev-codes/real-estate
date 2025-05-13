<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasPermissions
{
    /**
     * Check if the authenticated user has a specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        return Auth::check() && Auth::user()->can($permission);
    }

    /**
     * Check if the authenticated user has any of the specified permissions.
     */
    public function hasAnyPermission(array $permissions): bool
    {
        return Auth::check() && Auth::user()->hasAnyPermission($permissions);
    }

    /**
     * Check if the authenticated user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return Auth::check() && Auth::user()->hasRole($role);
    }
}
