<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MasterStandardEngineering;

class MasterStandardEngineeringPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_master_standard_engineering')
            || $user->hasPermissionTo('add_master_standard_engineering')
            || $user->hasPermissionTo('manage_master_standard_engineering')
            || $user->hasPermissionTo('delete_master_standard_engineering');
    }

    public function view(User $user, MasterStandardEngineering $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add_master_standard_engineering');
    }

    public function update(User $user, MasterStandardEngineering $model): bool
    {
        return $user->hasPermissionTo('manage_master_standard_engineering');
    }

    public function delete(User $user, MasterStandardEngineering $model): bool
    {
        return $user->hasPermissionTo('delete_master_standard_engineering');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete_master_standard_engineering');
    }

    public function restore(User $user, MasterStandardEngineering $model): bool
    {
        return $user->hasPermissionTo('manage_master_standard_engineering');
    }

    public function forceDelete(User $user, MasterStandardEngineering $model): bool
    {
        return $user->hasPermissionTo('delete_master_standard_engineering');
    }
}