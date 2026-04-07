<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_thickness_externals', function (Blueprint $table) {

            if (!Schema::hasColumn('master_thickness_externals', 'diameter_id')) {
                $table->foreignId('diameter_id')
                    ->after('id')
                    ->constrained('master_diameters')
                    ->cascadeOnDelete();
            }

            $table->decimal('thickness', 8, 2)->nullable()->change();

            $table->unique(['diameter_id', 'layer']);
        });
    }

    public function down(): void
    {
        Schema::table('master_thickness_externals', function (Blueprint $table) {
            $table->dropUnique(['diameter_id', 'layer']);
            $table->dropForeign(['diameter_id']);
            $table->dropColumn('diameter_id');
        });
    }
};
