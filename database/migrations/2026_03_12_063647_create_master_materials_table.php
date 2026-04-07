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
        Schema::create('master_materials', function (Blueprint $table) {
            $table->id();
            $table->string('material_id')->unique();
            $table->string('material_name');
            $table->string('trade_name')->nullable();
            $table->string('international_name')->nullable();

            // Relasi ke Master Material Types
            $table->foreignId('id_material_type')->constrained('master_material_types');

            // Relasi ke Master Pieces (Measurement/Unit)
            $table->foreignId('id_measurement')->constrained('master_pieces');
            $table->string('unit_measurement'); 
            $table->decimal('conversion_value', 15, 2)->default(1);

            // Relasi ke Master Pieces (Packing)
            $table->foreignId('id_packing')->constrained('master_pieces');
            $table->string('unit_packing'); 

            $table->text('description')->nullable();
            $table->integer('min_stock_day')->default(0);
            $table->integer('max_stock_day')->default(0);
            $table->decimal('monthly_requirement', 15, 2)->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_materials');
    }
};
