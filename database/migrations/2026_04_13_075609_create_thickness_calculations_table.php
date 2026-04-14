<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thickness_calculations', function (Blueprint $table) {
            $table->id();
            $table->string('calculation_code')->unique();
            $table->string('brand_name');
            $table->string('standard_product_name')->nullable();

            // Liner snapshot
            $table->foreignId('liner_id')->nullable()->constrained('thickness_liners')->nullOnDelete();
            $table->string('liner_code_snapshot')->nullable();
            $table->string('liner_material_type_snapshot')->nullable();
            $table->decimal('liner_thickness_snapshot', 8, 2)->nullable();

            // Struktur
            $table->string('temperature'); // 65 / 80
            $table->foreignId('pressure_nominal_id')->nullable()->constrained('master_pressure_nominals')->nullOnDelete();
            $table->string('pn_name_snapshot')->nullable();
            $table->decimal('pn_value_snapshot', 8, 2)->nullable();
            $table->string('vacuum_type')->nullable(); // intermitten / continues
            $table->decimal('vacuum_load_snapshot', 5, 2)->nullable();
            $table->integer('stiffness_snapshot')->nullable();

            // External (nullable)
            $table->string('external_layer_snapshot')->nullable();
            $table->boolean('use_external')->default(false);

            // Top Coat
            $table->boolean('use_top_coat')->default(false);

            $table->string('status')->default('draft'); // draft / final
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thickness_calculations');
    }
};