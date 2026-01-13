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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->decimal('quality_score', 3, 2)->nullable()->default(0.00)->change();
            $table->decimal('delivery_score', 3, 2)->nullable()->default(0.00)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->decimal('quality_score', 3, 2)->default(0.00)->nullable(false)->change();
            $table->decimal('delivery_score', 3, 2)->default(0.00)->nullable(false)->change();
        });
    }
};
