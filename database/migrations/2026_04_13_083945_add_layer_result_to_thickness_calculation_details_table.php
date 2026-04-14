<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('thickness_calculation_details', function (Blueprint $table) {
            // Layer yang cocok dengan diameter ini
            $table->foreignId('matched_layer_id')->nullable()->after('structure_rule')
                ->constrained('master_layers')->nullOnDelete();
            $table->string('matched_layer_code_snapshot')->nullable()->after('matched_layer_id');

            // 2 thickness terdekat (atas & bawah)
            $table->foreignId('thickness_lower_id')->nullable()->after('matched_layer_code_snapshot')
                ->constrained('master_layer_thicknesses')->nullOnDelete();
            $table->decimal('thickness_lower_value', 8, 2)->nullable()->after('thickness_lower_id');

            $table->foreignId('thickness_upper_id')->nullable()->after('thickness_lower_value')
                ->constrained('master_layer_thicknesses')->nullOnDelete();
            $table->decimal('thickness_upper_value', 8, 2)->nullable()->after('thickness_upper_id');

            // Pilihan user (setelah action "Proses Thickness")
            $table->foreignId('selected_thickness_id')->nullable()->after('thickness_upper_value')
                ->constrained('master_layer_thicknesses')->nullOnDelete();
            $table->decimal('selected_thickness_value', 8, 2)->nullable()->after('selected_thickness_id');
        });
    }

    public function down(): void
    {
        Schema::table('thickness_calculation_details', function (Blueprint $table) {
            $table->dropForeign(['matched_layer_id']);
            $table->dropForeign(['thickness_lower_id']);
            $table->dropForeign(['thickness_upper_id']);
            $table->dropForeign(['selected_thickness_id']);
            $table->dropColumn([
                'matched_layer_id',
                'matched_layer_code_snapshot',
                'thickness_lower_id',
                'thickness_lower_value',
                'thickness_upper_id',
                'thickness_upper_value',
                'selected_thickness_id',
                'selected_thickness_value',
            ]);
        });
    }
};