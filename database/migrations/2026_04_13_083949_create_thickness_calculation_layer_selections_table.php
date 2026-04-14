<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thickness_calculation_layer_selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calculation_id')->constrained('thickness_calculations')->cascadeOnDelete();
            $table->foreignId('detail_id')->constrained('thickness_calculation_details')->cascadeOnDelete();

            $table->string('diameter_inch_snapshot');
            $table->decimal('diameter_mm_snapshot', 8, 2);

            $table->unsignedBigInteger('layer_id')->nullable();
            $table->foreign('layer_id', 'tcls_layer_id_foreign')
                ->references('id')->on('master_layers')->nullOnDelete();
            $table->string('layer_code_snapshot');
            $table->string('layer_category_snapshot');

            $table->unsignedBigInteger('layer_thickness_id')->nullable();
            $table->foreign('layer_thickness_id', 'tcls_layer_thickness_id_foreign')
                ->references('id')->on('master_layer_thicknesses')->nullOnDelete();
            $table->decimal('thickness_value_snapshot', 8, 2);

            $table->unsignedBigInteger('selected_by')->nullable();
            $table->foreign('selected_by', 'tcls_selected_by_foreign')
                ->references('id')->on('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thickness_calculation_layer_selections');
    }
};
