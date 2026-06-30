<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionCleanupSeeder extends Seeder
{
    public function run(): void
    {
        Permission::where('guard_name', 'api')->delete();

        $modules = [
            'master_material_type',
            'master_diameter',
            'master_top_coat',
            'master_thickness_external',
            'thickness_liner',
            'thickness_pressure_temp',
            'thickness_stiffness',
            'thickness_vacuum',
            'master_material',
            'master_piece',
            'master_pressure_nominal',
            'master_standard_engineering',
            'master_layer',
            'master_application',
            'thickness_calculation',
            'product_catalog',
            'master_weight_formula',
        ];

        $actions = ['view', 'add', 'manage', 'delete'];

        foreach ($modules as $module) {
            // Hapus permission lama
            foreach ($actions as $action) {
                Permission::where('name', "{$action}_{$module}")->delete();
            }
            // Hapus manage lama jika masih ada
            Permission::where('name', "manage_{$module}")->delete();

            // Buat permission baru
            foreach ($actions as $action) {
                Permission::updateOrCreate([
                    'name' => "{$action}_{$module}",
                    'guard_name' => 'web',
                ]);
            }
        }

        $adminRole = Role::where('name', 'super_admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo(Permission::all());
        }

        $this->command->info('Permissions berhasil dibuat untuk: ' . implode(', ', $modules));
    }
}