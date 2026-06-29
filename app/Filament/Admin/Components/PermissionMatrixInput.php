<?php

namespace App\Filament\Admin\Components;

use Filament\Forms\Components\Field;
use Spatie\Permission\Models\Permission;

class PermissionMatrixInput extends Field
{
    protected string $view = 'filament.admin.components.permission-matrix-input';

    protected array $modules = [];
    protected array $actions = ['view', 'add', 'manage', 'delete'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->modules = [
            'master_material_type'        => 'Master Material Type',
            'master_diameter'             => 'Master Diameter',
            'master_top_coat'             => 'Master Topcoat',
            'master_thickness_external'   => 'Master Thickness External',
            'thickness_liner'             => 'Thickness Liner',
            'thickness_pressure_temp'     => 'Thickness Pressure Temp',
            'thickness_stiffness'         => 'Thickness Stiffness',
            'thickness_vacuum'            => 'Thickness Vacuum',
            'master_material'             => 'Master Material',
            'master_piece'                => 'Master Unit Packing',
            'master_pressure_nominal'     => 'Master Pressure Nominal',
            'master_standard_engineering' => 'Master Standard Engineering',
            'master_layer'                => 'Master Layer Structure',
            'master_application'          => 'Master Application',
            'thickness_calculation'       => 'Thickness Calculation',
            'product_catalog'             => 'Product Catalog',
            'master_weight_formula'       => 'Master Weight Formula'
        ];

        $this->default([]);
    }

    public function getModules(): array
    {
        return $this->modules;
    }

    public function getActions(): array
    {
        return $this->actions;
    }
}
