<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ThicknessCalculation;

class ProductCatalogPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_product_catalog')
            || $user->hasPermissionTo('add_product_catalog')
            || $user->hasPermissionTo('manage_product_catalog')
            || $user->hasPermissionTo('delete_product_catalog');
    }

    public function view(User $user, ThicknessCalculation $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add_product_catalog');
    }

    public function update(User $user, ThicknessCalculation $model): bool
    {
        return $user->hasPermissionTo('manage_product_catalog');
    }

    public function delete(User $user, ThicknessCalculation $model): bool
    {
        return $user->hasPermissionTo('delete_product_catalog');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete_product_catalog');
    }

    public function restore(User $user, ThicknessCalculation $model): bool
    {
        return $user->hasPermissionTo('manage_product_catalog');
    }

    public function forceDelete(User $user, ThicknessCalculation $model): bool
    {
        return $user->hasPermissionTo('delete_product_catalog');
    }
}
