<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('thickness_calculation_details', function (Blueprint $table) {
            $table->decimal('thickness_structure_adjustment', 8, 4)
                  ->default(0)
                  ->after('thickness_structure_used')
                  ->comment('Selisih tambahan structure agar total >= 3.50');
        });
    }

    public function down(): void
    {
        Schema::table('thickness_calculation_details', function (Blueprint $table) {
            $table->dropColumn('thickness_structure_adjustment');
        });
    }
};