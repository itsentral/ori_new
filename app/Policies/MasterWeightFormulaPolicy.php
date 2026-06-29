<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MasterWeightFormula;

class MasterWeightFormulaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_master_weight_formula')
            || $user->hasPermissionTo('add_master_weight_formula')
            || $user->hasPermissionTo('manage_master_weight_formula')
            || $user->hasPermissionTo('delete_master_weight_formula');
    }

    public function view(User $user, MasterWeightFormula $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add_master_weight_formula');
    }

    public function update(User $user, MasterWeightFormula $model): bool
    {
        return $user->hasPermissionTo('manage_master_weight_formula');
    }

    public function delete(User $user, MasterWeightFormula $model): bool
    {
        return $user->hasPermissionTo('delete_master_weight_formula');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete_master_weight_formula');
    }

    public function restore(User $user, MasterWeightFormula $model): bool
    {
        return $user->hasPermissionTo('manage_master_weight_formula');
    }

    public function forceDelete(User $user, MasterWeightFormula $model): bool
    {
        return $user->hasPermissionTo('delete_master_weight_formula');
    }
}
