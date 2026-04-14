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
        Schema::create('thickness_liners', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('corrosion'); // 1, 2, 3
            $table->tinyInteger('temprature'); // 1, 2, 3
            $table->string('liner_code')->unique();
            $table->string('liner_name');
            $table->foreignId('material_type_id')->constrained('master_material_types');
            $table->double('thickness_actual');
            $table->double('thickness_teori')->default(0);
            $table->text('layers_formula')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thickness_liners');
    }
};
