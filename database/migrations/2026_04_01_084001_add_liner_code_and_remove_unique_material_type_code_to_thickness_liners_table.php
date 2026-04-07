<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('thickness_liners', function (Blueprint $table) {
            // Tambah liner_code hanya jika belum ada
            if (!Schema::hasColumn('thickness_liners', 'liner_code')) {
                $table->string('liner_code')->nullable()->after('id');
            }

            // Drop unique index material_type_code
            $indexes = DB::select("SHOW INDEX FROM thickness_liners WHERE Non_unique = 0");
            foreach ($indexes as $index) {
                if ($index->Key_name === 'PRIMARY') continue;
                if (in_array($index->Column_name, ['liner_code', 'material_type_code'])) {
                    DB::statement("ALTER TABLE thickness_liners DROP INDEX `{$index->Key_name}`");
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('thickness_liners', function (Blueprint $table) {
            $table->dropColumn('liner_code');

            // Kembalikan unique jika rollback
            $table->unique('material_type_code');
        });
    }
};
