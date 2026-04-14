<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MasterMaterial;

class MasterMaterialPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_master_material')
            || $user->hasPermissionTo('add_master_material')
            || $user->hasPermissionTo('manage_master_material')
            || $user->hasPermissionTo('delete_master_material');
    }

    public function view(User $user, MasterMaterial $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add_master_material');
    }

    public function update(User $user, MasterMaterial $model): bool
    {
        return $user->hasPermissionTo('manage_master_material');
    }

    public function delete(User $user, MasterMaterial $model): bool
    {
        return $user->hasPermissionTo('delete_master_material');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete_master_material');
    }

    public function restore(User $user, MasterMaterial $model): bool
    {
        return $user->hasPermissionTo('manage_master_material');
    }

    public function forceDelete(User $user, MasterMaterial $model): bool
    {
        return $user->hasPermissionTo('delete_master_material');
    }
}