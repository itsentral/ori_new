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
        Schema::table('thickness_liner_layers', function (Blueprint $table) {
            $table->string('material_code')->after('layer_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thickness_liner_layers', function (Blueprint $table) {
            $table->dropColumn('material_code');
        });
    }
};
