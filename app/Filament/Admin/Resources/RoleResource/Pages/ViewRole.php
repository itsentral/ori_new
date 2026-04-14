<?php

namespace App\Filament\Admin\Resources\RoleResource\Pages;

use App\Filament\Admin\Components\PermissionMatrixInput;
use Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewRole extends ViewRecord
{
    protected static string $resource = RoleResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->disabled()
                ->columnSpan(1),

            Select::make('guard_name')
                ->options(['web' => 'web', 'api' => 'api'])
                ->disabled()
                ->columnSpan(1),

            PermissionMatrixInput::make('permissions')
                ->label('Permissions')
                ->columnSpanFull()
                ->disabled()
                ->afterStateHydrated(function ($component, $record) {
                    if ($record) {
                        $component->state(
                            $record->permissions->pluck('name')->toArray()
                        );
                    }
                }),
        ])->columns(2);
    }
}