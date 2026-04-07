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
        Schema::create('thickness_vacuums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_diameter_id')->constrained('master_diameters')->cascadeOnDelete();

            // Hardcode pilihan
            $table->string('vacuum_type'); // Intermittent / Continuous
            $table->string('vacuum_load'); // -0.1, -0.25, -0.5, -1.0

            $table->decimal('thickness', 8, 2);

            $table->softDeletes();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thickness_vacuums');
    }
};
