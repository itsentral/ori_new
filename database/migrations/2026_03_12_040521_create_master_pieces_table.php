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
        Schema::create('master_pieces', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('category_pieces'); // 1 = Unit, 2 = Packing
            $table->string('pieces_code');
            $table->string('pieces_name');
            $table->text('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['pieces_code', 'category_pieces']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_pieces');
    }
};
