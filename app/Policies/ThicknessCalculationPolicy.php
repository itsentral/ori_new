<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ThicknessCalculation;

class ThicknessCalculationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_thickness_calculation')
            || $user->hasPermissionTo('add_thickness_calculation')
            || $user->hasPermissionTo('manage_thickness_calculation')
            || $user->hasPermissionTo('delete_thickness_calculation');
    }

    public function view(User $user, ThicknessCalculation $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add_thickness_calculation');
    }

    public function update(User $user, ThicknessCalculation $model): bool
    {
        return $user->hasPermissionTo('manage_thickness_calculation');
    }

    public function delete(User $user, ThicknessCalculation $model): bool
    {
        return $user->hasPermissionTo('delete_thickness_calculation');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete_thickness_calculation');
    }

    public function restore(User $user, ThicknessCalculation $model): bool
    {
        return $user->hasPermissionTo('manage_thickness_calculation');
    }

    public function forceDelete(User $user, ThicknessCalculation $model): bool
    {
        return $user->hasPermissionTo('delete_thickness_calculation');
    }
}