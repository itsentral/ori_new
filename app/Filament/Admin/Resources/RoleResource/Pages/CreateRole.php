<?php

namespace App\Filament\Admin\Resources\RoleResource\Pages;

use App\Filament\Admin\Components\PermissionMatrixInput;
use Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            Select::make('guard_name')
                ->options(['web' => 'web', 'api' => 'api'])
                ->default('web')
                ->required(),

            PermissionMatrixInput::make('permissions')
                ->label('Permissions')
                ->columnSpanFull()
                ->default([]),
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['permissions']);
        return $data;
    }

    protected function afterCreate(): void
    {
        $permissions = $this->form->getState()['permissions'] ?? [];
        $this->record->syncPermissions($permissions);
    }
}