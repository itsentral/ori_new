<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MasterDiameter;

class MasterDiameterPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_master_diameter')
            || $user->hasPermissionTo('add_master_diameter')
            || $user->hasPermissionTo('manage_master_diameter')
            || $user->hasPermissionTo('delete_master_diameter');
    }

    public function view(User $user, MasterDiameter $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add_master_diameter');
    }

    public function update(User $user, MasterDiameter $model): bool
    {
        return $user->hasPermissionTo('manage_master_diameter');
    }

    public function delete(User $user, MasterDiameter $model): bool
    {
        return $user->hasPermissionTo('delete_master_diameter');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete_master_diameter');
    }

    public function restore(User $user, MasterDiameter $model): bool
    {
        return $user->hasPermissionTo('manage_master_diameter');
    }

    public function forceDelete(User $user, MasterDiameter $model): bool
    {
        return $user->hasPermissionTo('delete_master_diameter');
    }
}