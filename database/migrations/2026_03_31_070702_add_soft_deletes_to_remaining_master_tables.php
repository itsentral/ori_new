<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Daftar tabel yang masih kurang kolom soft deletes atau user stamps
     */
    protected array $tables = [
        'master_pressure_nominals'
    ];

    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (!Schema::hasColumn($tableName, 'created_by')) {
                        $table->foreignId('created_by')->nullable()->after('id')->constrained('users')->nullOnDelete();
                    }

                    if (!Schema::hasColumn($tableName, 'updated_by')) {
                        $table->foreignId('updated_by')->nullable()->after(Schema::hasColumn($tableName, 'created_by') ? 'created_by' : 'id')->constrained('users')->nullOnDelete();
                    }

                    if (!Schema::hasColumn($tableName, 'deleted_at')) {
                        $table->softDeletes();
                    }
                });
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (Schema::hasColumn($tableName, 'deleted_at')) {
                        $table->dropSoftDeletes();
                    }
                    if (Schema::hasColumn($tableName, 'updated_by')) {
                        $table->dropForeign(['updated_by']);
                        $table->dropColumn('updated_by');
                    }
                    if (Schema::hasColumn($tableName, 'created_by')) {
                        $table->dropForeign(['created_by']);
                        $table->dropColumn('created_by');
                    }
                });
            }
        }
    }
};