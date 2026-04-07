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
        Schema::create('master_top_coats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diameter_id')->constrained('master_diameters')->cascadeOnDelete();
            $table->decimal('thickness', 8, 2)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['diameter_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_top_coats');
    }
};
