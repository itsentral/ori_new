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
        Schema::create('material_type_engineerings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_type_id')
                ->constrained('master_material_types')
                ->cascadeOnDelete();
            $table->foreignId('engineering_id')
                ->constrained('master_standard_engineerings')
                ->cascadeOnDelete();
            $table->string('engineering_value');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_type_engineerings');
    }
};
