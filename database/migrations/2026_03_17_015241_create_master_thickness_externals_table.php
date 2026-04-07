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
        Schema::create('master_thickness_externals', function (Blueprint $table) {
            $table->id();
            $table->string('layer'); // Untuk 1V, 1M, 1M1V
            $table->decimal('thickness', 8, 2);
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_thickness_externals');
    }
};
