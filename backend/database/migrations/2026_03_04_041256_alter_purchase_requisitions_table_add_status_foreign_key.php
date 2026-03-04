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
        Schema::table('purchase_requisitions', function (Blueprint $table) {
            // 1. Agregar la nueva columna para la clave foránea
            $table->foreignId('purchase_requisition_status_id')->default(1)->after('status')->constrained('purchase_requisition_statuses');

            // Aquí iría la lógica para migrar los datos de la columna 'status' a la nueva columna 'purchase_requisition_status_id'
            // pero como es un entorno de desarrollo, es más fácil refrescar la base de datos.

            // 2. Eliminar la columna de estado anterior
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_requisitions', function (Blueprint $table) {
            // 1. Re-agregar la columna de estado anterior
            $table->enum('status', ['borrador', 'pendiente', 'aprobada', 'rechazada', 'en_cotizacion', 'ordenada', 'parcial', 'completada'])->default('borrador')->after('justification');

            // Aquí iría la lógica para revertir los datos si es necesario.

            // 2. Eliminar la clave foránea y la columna
            $table->dropForeign(['purchase_requisition_status_id']);
            $table->dropColumn('purchase_requisition_status_id');
        });
    }
};
