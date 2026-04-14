<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_applications', function (Blueprint $table) {
            $table->foreignId('calculation_id')
                ->nullable()
                ->after('description')
                ->constrained('thickness_calculations')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('master_applications', function (Blueprint $table) {
            $table->dropForeign(['calculation_id']);
            $table->dropColumn('calculation_id');
        });
    }
};