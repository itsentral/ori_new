<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ThicknessPressureTemp;

class ThicknessPressureTempPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_thickness_pressure_temp') || $user->hasPermissionTo('manage_thickness_pressure_temp');
    }

    public function view(User $user, ThicknessPressureTemp $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool { return $user->hasPermissionTo('manage_thickness_pressure_temp'); }
    public function update(User $user, ThicknessPressureTemp $model): bool { return $user->hasPermissionTo('manage_thickness_pressure_temp'); }
    public function delete(User $user, ThicknessPressureTemp $model): bool { return $user->hasPermissionTo('manage_thickness_pressure_temp'); }
    public function deleteAny(User $user): bool { return $user->hasPermissionTo('manage_thickness_pressure_temp'); }
    public function restore(User $user, ThicknessPressureTemp $model): bool { return $user->hasPermissionTo('manage_thickness_pressure_temp'); }
    public function forceDelete(User $user, ThicknessPressureTemp $model): bool { return $user->hasPermissionTo('manage_thickness_pressure_temp'); }
}