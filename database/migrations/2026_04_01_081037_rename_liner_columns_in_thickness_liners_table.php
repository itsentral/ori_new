<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('thickness_liners', function (Blueprint $table) {
            $table->renameColumn('liner_code', 'material_type_code');
            $table->renameColumn('liner_name', 'material_type_name');
        });
    }

    public function down(): void
    {
        Schema::table('thickness_liners', function (Blueprint $table) {
            $table->renameColumn('material_type_code', 'liner_code');
            $table->renameColumn('material_type_name', 'liner_name');
        });
    }
};
