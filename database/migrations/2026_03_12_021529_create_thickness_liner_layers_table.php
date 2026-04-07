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
        Schema::create('thickness_liner_layers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('liner_id')->constrained('thickness_liners')->cascadeOnDelete();
            $table->integer('layer_no');
            $table->foreignId('material_type_id')->constrained('master_material_types'); // Filter category 2
            $table->double('engineering_value'); // C006
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thickness_liner_layers');
    }
};
