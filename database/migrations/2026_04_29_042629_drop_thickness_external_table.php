<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('thickness_externals');
    }

    public function down(): void
    {
        Schema::create('thickness_externals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diameter_id')->nullable();
            $table->string('layer')->nullable();
            $table->decimal('thickness', 8, 2)->nullable();
            $table->timestamps();
        });
    }
};