<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thickness_calculation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calculation_id')->constrained('thickness_calculations')->cascadeOnDelete();

            // Diameter snapshot
            $table->foreignId('diameter_id')->nullable()->constrained('master_diameters')->nullOnDelete();
            $table->string('diameter_inch_snapshot');
            $table->decimal('diameter_mm_snapshot', 8, 2);

            // Thickness komponen
            $table->decimal('thickness_liner', 8, 2)->default(0);
            $table->decimal('thickness_pressure_temp', 8, 2)->default(0);
            $table->decimal('thickness_vacuum', 8, 2)->default(0);
            $table->decimal('thickness_stiffness', 8, 2)->default(0);
            $table->decimal('thickness_external', 8, 2)->default(0);
            $table->decimal('thickness_top_coat', 8, 2)->default(0);

            // Hasil kalkulasi
            $table->decimal('thickness_structure_raw', 8, 2)->default(0);  // max(PN, VC, SN)
            $table->decimal('thickness_structure_used', 8, 2)->default(0); // setelah rule 3.5
            $table->decimal('total_thickness', 8, 2)->default(0);          // liner+structure+ext+tc
            $table->string('structure_rule')->nullable();                   // adjusted / as_is

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thickness_calculation_details');
    }
};