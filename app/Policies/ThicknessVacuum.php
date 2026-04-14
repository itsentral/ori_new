<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ThicknessVacuum;

class ThicknessVacuumPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_thickness_vacuum')
            || $user->hasPermissionTo('add_thickness_vacuum')
            || $user->hasPermissionTo('manage_thickness_vacuum')
            || $user->hasPermissionTo('delete_thickness_vacuum');
    }

    public function view(User $user, ThicknessVacuum $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add_thickness_vacuum');
    }

    public function update(User $user, ThicknessVacuum $model): bool
    {
        return $user->hasPermissionTo('manage_thickness_vacuum');
    }

    public function delete(User $user, ThicknessVacuum $model): bool
    {
        return $user->hasPermissionTo('delete_thickness_vacuum');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete_thickness_vacuum');
    }

    public function restore(User $user, ThicknessVacuum $model): bool
    {
        return $user->hasPermissionTo('manage_thickness_vacuum');
    }

    public function forceDelete(User $user, ThicknessVacuum $model): bool
    {
        return $user->hasPermissionTo('delete_thickness_vacuum');
    }
}