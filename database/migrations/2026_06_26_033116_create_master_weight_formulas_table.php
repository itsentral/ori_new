<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_weight_formulas', function (Blueprint $table) {
            $table->id();
            $table->string('formula_code')->unique();
            $table->string('formula_name');
            $table->string('formula_type'); // pipe / fitting
            $table->json('waste_pipe')->nullable()->comment('Waste Potongan, Ceceran, Diptank, Glass Overlap');
            $table->json('luas_area')->nullable()->comment('Rumus luas area');
            $table->json('resin_contain')->nullable()->comment('Standard Contain ratios');
            $table->json('setting_fw')->nullable()->comment('Setting Filament Winding');
            $table->json('glass_config')->nullable()->comment('Konfigurasi Glass / jumlah layer');
            $table->json('glass_weight')->nullable()->comment('Rumus Glass Weight');
            $table->json('resin_weight')->nullable()->comment('Rumus Resin Weight');
            $table->json('additive')->nullable()->comment('Rumus Additive');
            $table->json('mirror_glaze')->nullable()->comment('Rumus Mirror Glaze');
            $table->json('additional_additive')->nullable()->comment('Rumus Additional Additive');
            $table->json('total_weight')->nullable()->comment('Rumus Total Berat');
            $table->json('fitting_params')->nullable()->comment('Parameter khusus fitting: radius, faktor, sudut, overlap');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_weight_formulas');
    }
};
