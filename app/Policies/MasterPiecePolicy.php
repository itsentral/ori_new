<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MasterPiece;

class MasterPiecePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_master_piece')
            || $user->hasPermissionTo('add_master_piece')
            || $user->hasPermissionTo('manage_master_piece')
            || $user->hasPermissionTo('delete_master_piece');
    }

    public function view(User $user, MasterPiece $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('add_master_piece');
    }

    public function update(User $user, MasterPiece $model): bool
    {
        return $user->hasPermissionTo('manage_master_piece');
    }

    public function delete(User $user, MasterPiece $model): bool
    {
        return $user->hasPermissionTo('delete_master_piece');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete_master_piece');
    }

    public function restore(User $user, MasterPiece $model): bool
    {
        return $user->hasPermissionTo('manage_master_piece');
    }

    public function forceDelete(User $user, MasterPiece $model): bool
    {
        return $user->hasPermissionTo('delete_master_piece');
    }
}