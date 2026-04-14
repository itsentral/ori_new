<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('thickness_calculations', function (Blueprint $table) {
            $table->string('layer_category')->nullable()->after('use_top_coat'); // filament_winding / hand_layup
            $table->string('layer_selection_status')->default('pending')->after('layer_category'); // pending / selected
        });
    }

    public function down(): void
    {
        Schema::table('thickness_calculations', function (Blueprint $table) {
            $table->dropColumn(['layer_category', 'layer_selection_status']);
        });
    }
};