<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('budget_requests', function (Blueprint $table) {
            $table->foreignId('budget_category_id')
                ->after('department_id')
                ->constrained('budget_categories');
        });

        DB::statement("ALTER TABLE `budget_requests` MODIFY COLUMN `budget_category_id` BIGINT UNSIGNED NOT NULL COMMENT 'Categoría a distribuir'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budget_requests', function (Blueprint $table) {
            $table->dropForeign(['budget_category_id']);
            $table->dropColumn('budget_category_id');
        });
    }
};
