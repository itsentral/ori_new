<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role; // Tambahkan ini
use Illuminate\Support\Facades\Gate;

// Import Model dan Policy Anda
use App\Models\MasterDiameter;
use App\Models\MasterMaterialType;
use App\Policies\MasterDiameterPolicy;
use App\Policies\MasterMaterialTypePolicy;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1. Super Admin Bypass
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });

        // 2. Daftarkan Policy Role & Permission (Sudah ada sebelumnya)
        Gate::policy(Role::class, \App\Policies\RolePolicy::class);
        Gate::policy(Permission::class, \App\Policies\PermissionPolicy::class);

        // 3. Daftarkan Policy untuk Modul Bisnis Anda
        Gate::policy(MasterDiameter::class, MasterDiameterPolicy::class);
        Gate::policy(MasterMaterialType::class, MasterMaterialTypePolicy::class);
        
        // Nanti jika ada modul baru (misal: MaterialTypeDetail), tambahkan di bawah sini
        // Gate::policy(\App\Models\MaterialTypeDetail::class, \App\Policies\MaterialTypeDetailPolicy::class);
    }
}