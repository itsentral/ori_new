<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MasterTopCoat;

class MasterTopCoatPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_master_topcoat') || $user->hasPermissionTo('manage_master_topcoat');
    }

    public function view(User $user, MasterTopCoat $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool { return $user->hasPermissionTo('manage_master_topcoat'); }
    public function update(User $user, MasterTopCoat $model): bool { return $user->hasPermissionTo('manage_master_topcoat'); }
    public function delete(User $user, MasterTopCoat $model): bool { return $user->hasPermissionTo('manage_master_topcoat'); }
    public function deleteAny(User $user): bool { return $user->hasPermissionTo('manage_master_topcoat'); }
    public function restore(User $user, MasterTopCoat $model): bool { return $user->hasPermissionTo('manage_master_topcoat'); }
    public function forceDelete(User $user, MasterTopCoat $model): bool { return $user->hasPermissionTo('manage_master_topcoat'); }
}