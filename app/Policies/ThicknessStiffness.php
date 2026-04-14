<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ThicknessStiffness;

class ThicknessStiffnessPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_thickness_stiffness')
            || $user->hasPermissionTo('add_thickness_stiffness')
            || $user->hasPermissionTo('manage_thickness_stiffness')
            || $user->hasPermissionTo('delete_thickness_stiffness');
    }

    public function view(User $user, ThicknessStiffness $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add_thickness_stiffness');
    }

    public function update(User $user, ThicknessStiffness $model): bool
    {
        return $user->hasPermissionTo('manage_thickness_stiffness');
    }

    public function delete(User $user, ThicknessStiffness $model): bool
    {
        return $user->hasPermissionTo('delete_thickness_stiffness');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete_thickness_stiffness');
    }

    public function restore(User $user, ThicknessStiffness $model): bool
    {
        return $user->hasPermissionTo('manage_thickness_stiffness');
    }

    public function forceDelete(User $user, ThicknessStiffness $model): bool
    {
        return $user->hasPermissionTo('delete_thickness_stiffness');
    }
}