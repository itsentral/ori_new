<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('thickness_calculation_details', function (Blueprint $table) {
            $table->decimal('thickness_brocure', 8, 2)
                  ->nullable()
                  ->after('selected_thickness_value')
                  ->comment('Thickness brocure value for product catalog');
        });
    }

    public function down(): void
    {
        Schema::table('thickness_calculation_details', function (Blueprint $table) {
            $table->dropColumn('thickness_brocure');
        });
    }
};
