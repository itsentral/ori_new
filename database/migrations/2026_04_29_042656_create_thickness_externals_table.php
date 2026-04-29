<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thickness_externals', function (Blueprint $table) {
            $table->id();
            $table->string('external_code')->unique()->nullable();
            $table->unsignedBigInteger('material_type_id')->nullable();
            $table->string('material_type_code')->nullable();
            $table->string('material_type_name')->nullable();
            $table->decimal('thickness_actual', 8, 2)->nullable();
            $table->decimal('thickness_teori', 8, 2)->default(0);
            $table->string('layers_formula')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thickness_externals');
    }
};