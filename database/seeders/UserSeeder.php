<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'username'  => 'admin',
                'full_name' => 'Administrator',
                'nick_name' => 'Admin',
                'password'  => bcrypt('password'),
                'is_active' => true,
            ]
        );

        $user->assignRole($role);
    }
}