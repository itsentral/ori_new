<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MasterPressureNominal;

class MasterPressureNominalPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_master_pressure_nominal') || $user->hasPermissionTo('manage_master_pressure_nominal');
    }

    public function view(User $user, MasterPressureNominal $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage_master_pressure_nominal');
    }
    public function update(User $user, MasterPressureNominal $model): bool
    {
        return $user->hasPermissionTo('manage_master_pressure_nominal');
    }
    public function delete(User $user, MasterPressureNominal $model): bool
    {
        return $user->hasPermissionTo('manage_master_pressure_nominal');
    }
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('manage_master_pressure_nominal');
    }
    public function restore(User $user, MasterPressureNominal $model): bool
    {
        return $user->hasPermissionTo('manage_master_pressure_nominal');
    }
    public function forceDelete(User $user, MasterPressureNominal $model): bool
    {
        return $user->hasPermissionTo('manage_master_pressure_nominal');
    }
}
