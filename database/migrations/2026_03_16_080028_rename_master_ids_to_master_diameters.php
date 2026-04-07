<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ganti nama tabel
        Schema::rename('master_ids', 'master_diameters');

        // 2. Ganti nama kolom (Membutuhkan library: composer require doctrine/dbal)
        Schema::table('master_diameters', function (Blueprint $table) {
            $table->renameColumn('id_inch', 'diameter_inch');
            $table->renameColumn('id_mm', 'diameter_mm');
        });
    }

    public function down(): void
    {
        Schema::table('master_diameters', function (Blueprint $table) {
            $table->renameColumn('diameter_inch', 'id_inch');
            $table->renameColumn('diameter_mm', 'id_mm');
        });
        Schema::rename('master_diameters', 'master_ids');
    }
};
