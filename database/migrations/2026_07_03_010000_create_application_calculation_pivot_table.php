<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('application_calculation')) {
            Schema::create('application_calculation', function (Blueprint $table) {
                $table->id();
                $table->foreignId('calculation_id')->constrained('thickness_calculations')->cascadeOnDelete();
                $table->foreignId('application_id')->constrained('master_applications')->cascadeOnDelete();
                $table->timestamps();
            });
        }

        // Migrate existing data from calculation_id column (if column still exists)
        if (Schema::hasColumn('master_applications', 'calculation_id')) {
            $applications = \Illuminate\Support\Facades\DB::table('master_applications')
                ->whereNotNull('calculation_id')
                ->get();

            foreach ($applications as $app) {
                \Illuminate\Support\Facades\DB::table('application_calculation')->insert([
                    'calculation_id' => $app->calculation_id,
                    'application_id' => $app->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Remove old column
            Schema::table('master_applications', function (Blueprint $table) {
                $table->dropForeign(['calculation_id']);
                $table->dropColumn('calculation_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('master_applications', function (Blueprint $table) {
            $table->foreignId('calculation_id')
                ->nullable()
                ->after('description')
                ->constrained('thickness_calculations')
                ->nullOnDelete();
        });

        // Migrate data back (only last assignment per app)
        $pivots = \Illuminate\Support\Facades\DB::table('application_calculation')->get();
        foreach ($pivots as $pivot) {
            \App\Models\MasterApplication::where('id', $pivot->application_id)
                ->update(['calculation_id' => $pivot->calculation_id]);
        }

        Schema::dropIfExists('application_calculation');
    }
};
