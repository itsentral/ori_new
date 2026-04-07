<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $tables = [
        'master_resins',
        'master_standard_engineerings',
        'material_type_details',
        'material_type_engineerings',
        'thickness_liner_layers',
        'thickness_liners',
    ];

    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                // Tambah created_by jika belum ada
                if (!Schema::hasColumn($tableName, 'created_by')) {
                    $table->foreignId('created_by')->nullable()->after('id')->constrained('users')->nullOnDelete();
                }

                // Tambah updated_by jika belum ada
                if (!Schema::hasColumn($tableName, 'updated_by')) {
                    $table->foreignId('updated_by')->nullable()->after(Schema::hasColumn($tableName, 'created_by') ? 'created_by' : 'id')->constrained('users')->nullOnDelete();
                }

            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'created_by')) {
                    $table->dropForeign(['created_by']);
                    $table->dropColumn('created_by');
                }
                if (Schema::hasColumn($tableName, 'updated_by')) {
                    $table->dropForeign(['updated_by']);
                    $table->dropColumn('updated_by');
                }
                if (Schema::hasColumn($tableName, 'deleted_at')) {
                    $table->dropSoftDeletes();
                }
            });
        }
    }
};