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
        // 1. Level 1: Master Layers
        Schema::create('master_layers', function (Blueprint $table) {
            $table->id();
            $table->string('layer_code')->unique();
            $table->string('category')->nullable();
            $table->string('operator');
            $table->foreignId('diameter_id_1')->constrained('master_diameters');
            $table->foreignId('diameter_id_2')->nullable()->constrained('master_diameters');
            $table->softDeletes();
            $table->timestamps();
        });

        // 2. Level 2: Master Layer Thicknesses
        Schema::create('master_layer_thicknesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_layer_id')
                ->constrained('master_layers')
                ->cascadeOnDelete();
            $table->decimal('thickness', 8, 2);
            $table->softDeletes();
            $table->timestamps();
        });

        // 3. Level 3: Master Layer Thickness Details (Stages & Steps)
        Schema::create('master_layer_thickness_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layer_thickness_id')
                ->constrained('master_layer_thicknesses', 'id', 'mltd_thickness_id_foreign')
                ->cascadeOnDelete();
            $table->integer('stage_number');
            $table->integer('step_number');
            $table->string('layer_value')->nullable();
            $table->foreignId('material_type_id')
                ->nullable()
                ->constrained('master_material_types');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_layer_thickness_details');
        Schema::dropIfExists('master_layer_thicknesses');
        Schema::dropIfExists('master_layers');
    }
};