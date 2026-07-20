<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('thickness_calculations', function (Blueprint $table) {
            $table->unsignedBigInteger('technology_id')->nullable();
            $table->unsignedBigInteger('liner_resin_id')->nullable();
            $table->unsignedBigInteger('structure_resin_id')->nullable();
            $table->unsignedBigInteger('external_resin_id')->nullable();
            $table->unsignedBigInteger('top_coat_resin_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('thickness_calculations', function (Blueprint $table) {
            $table->dropColumn([
                'technology_id',
                'liner_resin_id',
                'structure_resin_id',
                'external_resin_id',
                'top_coat_resin_id',
            ]);
        });
    }
};
