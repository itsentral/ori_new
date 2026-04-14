<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ThicknessLiner;

class ThicknessLinerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_thickness_liner')
            || $user->hasPermissionTo('add_thickness_liner')
            || $user->hasPermissionTo('manage_thickness_liner')
            || $user->hasPermissionTo('delete_thickness_liner');
    }

    public function view(User $user, ThicknessLiner $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add_thickness_liner');
    }

    public function update(User $user, ThicknessLiner $model): bool
    {
        return $user->hasPermissionTo('manage_thickness_liner');
    }

    public function delete(User $user, ThicknessLiner $model): bool
    {
        return $user->hasPermissionTo('delete_thickness_liner');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete_thickness_liner');
    }

    public function restore(User $user, ThicknessLiner $model): bool
    {
        return $user->hasPermissionTo('manage_thickness_liner');
    }

    public function forceDelete(User $user, ThicknessLiner $model): bool
    {
        return $user->hasPermissionTo('delete_thickness_liner');
    }
}