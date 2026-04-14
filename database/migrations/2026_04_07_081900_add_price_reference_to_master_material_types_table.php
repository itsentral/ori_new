<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_material_types', function (Blueprint $table) {
            $table->decimal('price_kurs', 15, 2)->nullable()->after('remark');
            $table->decimal('price_usd', 15, 2)->nullable()->after('price_kurs');
            $table->decimal('price_idr', 15, 2)->nullable()->after('price_usd');
        });
    }

    public function down(): void
    {
        Schema::table('master_material_types', function (Blueprint $table) {
            $table->dropColumn(['price_kurs', 'price_usd', 'price_idr']);
        });
    }
};
