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
        Schema::create('material_type_details', function (Blueprint $table) {
            $table->id();
            // Relasi ke Master Material Type
            $table->foreignId('material_type_id')
                ->constrained('master_material_types')
                ->cascadeOnDelete();

            // Kolom Engineering Hardcode
            $table->double('glass_grammage')->nullable();
            $table->double('glass_percentage')->nullable();
            $table->double('resin_percentage')->nullable();
            $table->double('density_glass')->nullable();
            $table->double('density_resin')->nullable();
            $table->double('structure_thickness')->nullable();
            $table->double('liner_thickness')->nullable();
            $table->double('top_coat')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_type_details');
    }
};
