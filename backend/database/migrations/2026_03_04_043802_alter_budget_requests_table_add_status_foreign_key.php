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
        Schema::table('budget_requests', function (Blueprint $table) {
            // 1. Agregar la nueva columna para la clave foránea
            $table->foreignId('budget_request_status_id')->default(1)->after('status')->constrained('budget_request_statuses');

            // 2. Eliminar la columna de estado anterior
            $table->dropColumn('status');
            $table->dropColumn('total_amount');
            $table->dropColumn('approved_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budget_requests', function (Blueprint $table) {
            // 1. Re-agregar la columna de estado anterior
            $table->enum('status', ['borrador', 'en_revision', 'aprobado', 'rechazado'])->default('borrador')->after('department_id');

            // 2. Eliminar la clave foránea y la columna
            $table->dropForeign(['budget_request_status_id']);
            $table->dropColumn('budget_request_status_id');
        });
    }
};
