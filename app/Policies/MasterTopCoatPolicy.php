<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MasterTopCoat;

class MasterTopCoatPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_master_top_coat')
            || $user->hasPermissionTo('add_master_top_coat')
            || $user->hasPermissionTo('manage_master_top_coat')
            || $user->hasPermissionTo('delete_master_top_coat');
    }

    public function view(User $user, MasterTopCoat $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add_master_top_coat');
    }

    public function update(User $user, MasterTopCoat $model): bool
    {
        return $user->hasPermissionTo('manage_master_top_coat');
    }

    public function delete(User $user, MasterTopCoat $model): bool
    {
        return $user->hasPermissionTo('delete_master_top_coat');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete_master_top_coat');
    }

    public function restore(User $user, MasterTopCoat $model): bool
    {
        return $user->hasPermissionTo('manage_master_top_coat');
    }

    public function forceDelete(User $user, MasterTopCoat $model): bool
    {
        return $user->hasPermissionTo('delete_master_top_coat');
    }
}