<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('thickness_calculations', function (Blueprint $table) {
            $table->renameColumn('external_layer_snapshot', 'external_id');
            $table->string('external_code_snapshot')->nullable()->after('external_id');
            $table->decimal('external_thickness_snapshot', 8, 2)->nullable()->after('external_code_snapshot');
        });
    }

    public function down(): void
    {
        Schema::table('thickness_calculations', function (Blueprint $table) {
            $table->renameColumn('external_id', 'external_layer_snapshot');
            $table->dropColumn(['external_code_snapshot', 'external_thickness_snapshot']);
        });
    }
};
