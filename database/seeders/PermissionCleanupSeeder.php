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
            'master_diameter',
            'master_material_type', 
            'master_topcoat',
            'master_thickness_external',
            'thickness_liner',
            'thickness_pressure_temp',
            'thickness_stiffness',
            'thickness_vacuum',
            'master_material',
            'master_piece',
            'master_pressure_nominal',
            'master_standard_engineering',
        ];

        foreach ($modules as $module) {
            $searchName = str_replace('_', '', $module);
            Permission::where('name', 'like', "%{$searchName}%")->delete();
            Permission::where('name', 'like', "%{$module}%")->delete();

            Permission::updateOrCreate(['name' => "view_{$module}", 'guard_name' => 'web']);
            Permission::updateOrCreate(['name' => "manage_{$module}", 'guard_name' => 'web']);
        }

        $adminRole = Role::where('name', 'super_admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo(Permission::all());
        }

        $this->command->info('Cleanup & Simplification berhasil untuk: ' . implode(', ', $modules));
    }
}
