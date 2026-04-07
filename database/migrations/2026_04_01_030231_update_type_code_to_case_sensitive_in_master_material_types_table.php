<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_material_types', function (Blueprint $table) {
            // Mengubah kolom menjadi binary collation agar case-sensitive
            $table->string('type_code')->collation('utf8mb4_bin')->change();
        });
    }

    public function down(): void
    {
        Schema::table('master_material_types', function (Blueprint $table) {
            // Mengembalikan ke case-insensitive jika rollback
            $table->string('type_code')->collation('utf8mb4_unicode_ci')->change();
        });
    }
};
