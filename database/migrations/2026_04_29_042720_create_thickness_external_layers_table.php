<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thickness_external_layers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('external_id')->constrained('thickness_externals')->cascadeOnDelete();
            $table->unsignedInteger('layer_no')->default(0);
            $table->string('material_code')->nullable();
            $table->unsignedBigInteger('material_type_id')->nullable();
            $table->decimal('engineering_value', 8, 4)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thickness_external_layers');
    }
};