<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MasterLayer;

class MasterLayerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_master_layer')
            || $user->hasPermissionTo('add_master_layer')
            || $user->hasPermissionTo('manage_master_layer')
            || $user->hasPermissionTo('delete_master_layer');
    }

    public function view(User $user, MasterLayer $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add_master_layer');
    }

    public function update(User $user, MasterLayer $model): bool
    {
        return $user->hasPermissionTo('manage_master_layer');
    }

    public function delete(User $user, MasterLayer $model): bool
    {
        return $user->hasPermissionTo('delete_master_layer');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete_master_layer');
    }

    public function restore(User $user, MasterLayer $model): bool
    {
        return $user->hasPermissionTo('manage_master_layer');
    }

    public function forceDelete(User $user, MasterLayer $model): bool
    {
        return $user->hasPermissionTo('delete_master_layer');
    }
}