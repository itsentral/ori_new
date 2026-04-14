<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MasterApplication;

class MasterApplicationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_master_application')
            || $user->hasPermissionTo('add_master_application')
            || $user->hasPermissionTo('manage_master_application')
            || $user->hasPermissionTo('delete_master_application');
    }

    public function view(User $user, MasterApplication $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add_master_application');
    }

    public function update(User $user, MasterApplication $model): bool
    {
        return $user->hasPermissionTo('manage_master_application');
    }

    public function delete(User $user, MasterApplication $model): bool
    {
        return $user->hasPermissionTo('delete_master_application');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete_master_application');
    }

    public function restore(User $user, MasterApplication $model): bool
    {
        return $user->hasPermissionTo('manage_master_application');
    }

    public function forceDelete(User $user, MasterApplication $model): bool
    {
        return $user->hasPermissionTo('delete_master_application');
    }
}