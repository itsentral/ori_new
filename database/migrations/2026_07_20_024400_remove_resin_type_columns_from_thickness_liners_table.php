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
        Schema::table('thickness_liners', function (Blueprint $table) {
            // Drop foreign keys first if they exist
            // Cek FK untuk material_type_id berdasarkan COLUMN_NAME
            $materialTypeFks = \Illuminate\Support\Facades\DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                  AND TABLE_NAME = 'thickness_liners' 
                  AND COLUMN_NAME = 'material_type_id'
                  AND REFERENCED_TABLE_NAME IS NOT NULL
            ");

            if (Schema::hasColumn('thickness_liners', 'material_type_id')) {
                foreach ($materialTypeFks as $fk) {
                    $table->dropForeign($fk->CONSTRAINT_NAME);
                }
                $table->dropColumn('material_type_id');
            }
            
            // Cek FK untuk material_id berdasarkan COLUMN_NAME
            $materialIdFks = \Illuminate\Support\Facades\DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                  AND TABLE_NAME = 'thickness_liners' 
                  AND COLUMN_NAME = 'material_id'
                  AND REFERENCED_TABLE_NAME IS NOT NULL
            ");

            if (Schema::hasColumn('thickness_liners', 'material_id')) {
                foreach ($materialIdFks as $fk) {
                    $table->dropForeign($fk->CONSTRAINT_NAME);
                }
                $table->dropColumn('material_id');
            }

            // Drop columns
            $columnsToDrop = [];
            if (Schema::hasColumn('thickness_liners', 'material_type_code')) {
                $columnsToDrop[] = 'material_type_code';
            }
            if (Schema::hasColumn('thickness_liners', 'material_type_name')) {
                $columnsToDrop[] = 'material_type_name';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thickness_liners', function (Blueprint $table) {
            $table->foreignId('material_type_id')->nullable()->constrained('master_material_types');
            $table->foreignId('material_id')->nullable()->constrained('master_materials');
            $table->string('material_type_code')->nullable();
            $table->string('material_type_name')->nullable();
        });
    }
};
