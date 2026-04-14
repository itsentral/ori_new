<?php

namespace App\Filament\Admin\Resources;

use Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource as BaseRoleResource;

class RoleResource extends BaseRoleResource
{
    public static function getPages(): array
    {
        return array_merge(parent::getPages(), [
            'create' => \App\Filament\Admin\Resources\RoleResource\Pages\CreateRole::route('/create'),
            'edit' => \App\Filament\Admin\Resources\RoleResource\Pages\EditRole::route('/{record}/edit'),
            'view'   => \App\Filament\Admin\Resources\RoleResource\Pages\ViewRole::route('/{record}'),
        ]);
    }
}
