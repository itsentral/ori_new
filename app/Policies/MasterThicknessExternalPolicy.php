<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MasterThicknessExternal;

class MasterThicknessExternalPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_master_thickness_external')
            || $user->hasPermissionTo('add_master_thickness_external')
            || $user->hasPermissionTo('manage_master_thickness_external')
            || $user->hasPermissionTo('delete_master_thickness_external');
    }

    public function view(User $user, MasterThicknessExternal $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add_master_thickness_external');
    }

    public function update(User $user, MasterThicknessExternal $model): bool
    {
        return $user->hasPermissionTo('manage_master_thickness_external');
    }

    public function delete(User $user, MasterThicknessExternal $model): bool
    {
        return $user->hasPermissionTo('delete_master_thickness_external');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete_master_thickness_external');
    }

    public function restore(User $user, MasterThicknessExternal $model): bool
    {
        return $user->hasPermissionTo('manage_master_thickness_external');
    }

    public function forceDelete(User $user, MasterThicknessExternal $model): bool
    {
        return $user->hasPermissionTo('delete_master_thickness_external');
    }
}