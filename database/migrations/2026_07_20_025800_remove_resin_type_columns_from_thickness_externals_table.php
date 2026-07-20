<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('thickness_externals', function (Blueprint $table) {

            // Drop columns
            $columnsToDrop = [];
            if (Schema::hasColumn('thickness_externals', 'material_type_id')) {
                $columnsToDrop[] = 'material_type_id';
            }
            if (Schema::hasColumn('thickness_externals', 'material_type_code')) {
                $columnsToDrop[] = 'material_type_code';
            }
            if (Schema::hasColumn('thickness_externals', 'material_type_name')) {
                $columnsToDrop[] = 'material_type_name';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    public function down(): void
    {
        Schema::table('thickness_externals', function (Blueprint $table) {
            $table->unsignedBigInteger('material_type_id')->nullable();
            $table->string('material_type_code')->nullable();
            $table->string('material_type_name')->nullable();
        });
    }
};
