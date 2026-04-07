<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MasterMaterialType;

class MasterMaterialTypePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_master_material_type')
            || $user->hasPermissionTo('manage_master_material_type');
    }

    public function view(User $user, MasterMaterialType $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage_master_material_type');
    }

    public function update(User $user, MasterMaterialType $model): bool
    {
        return $user->hasPermissionTo('manage_master_material_type');
    }

    public function delete(User $user, MasterMaterialType $model): bool
    {
        return $user->hasPermissionTo('manage_master_material_type');
    }

    // Aksi massal Filament
    public function deleteAny(User $user): bool
    {
        return $this->update($user, new MasterMaterialType());
    }
    public function restore(User $user, MasterMaterialType $model): bool
    {
        return $this->update($user, $model);
    }
    public function forceDelete(User $user, MasterMaterialType $model): bool
    {
        return $this->update($user, $model);
    }
}
