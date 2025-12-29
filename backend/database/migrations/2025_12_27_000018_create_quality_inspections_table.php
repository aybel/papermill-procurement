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
        Schema::create('quality_inspections', function (Blueprint $table) {
            $table->id()->comment('ID autoincremental');
            $table->foreignId('receipt_id')->constrained('receipts')->comment('FK: Recibo de material (ref: receipts.id)');
            $table->foreignId('po_item_id')->constrained('purchase_order_items')->comment('FK: Ítem de la orden inspeccionado (ref: purchase_order_items.id)');

            // Pruebas específicas para papel
            $table->decimal('grammage_test', 10, 2)->nullable()->comment('Resultado de prueba de gramaje (g/m²)');
            $table->string('grammage_status', 20)->nullable()->comment('Estado de gramaje: pass, fail, warning');

            $table->decimal('humidity_test', 5, 2)->nullable()->comment('Resultado de prueba de humedad (%)');
            $table->string('humidity_status', 20)->nullable()->comment('Estado de humedad: pass, fail, warning');

            $table->decimal('thickness_test', 8, 4)->nullable()->comment('Resultado de prueba de calibre/espesor (mm)');
            $table->string('thickness_status', 20)->nullable()->comment('Estado de espesor: pass, fail, warning');

            $table->decimal('tensile_strength_test', 10, 2)->nullable()->comment('Resultado de resistencia a tracción');
            $table->string('tensile_status', 20)->nullable()->comment('Estado de resistencia: pass, fail, warning');

            $table->text('visual_inspection')->nullable()->comment('Observaciones de inspección visual');
            $table->text('defects_found')->nullable()->comment('Defectos encontrados durante la inspección');

            $table->string('overall_status', 20)->default('pending')->comment('Estado general: pending, passed, failed, conditional');

            $table->foreignId('inspector_id')->constrained('users')->comment('FK: Inspector responsable (ref: users.id)');
            $table->timestamp('inspected_at')->useCurrent()->comment('Fecha y hora de la inspección');

            $table->timestamp('created_at')->useCurrent()->comment('Fecha de creación del registro');

            $table->index('inspected_at', 'idx_quality_inspections_date'); // Índice para búsquedas por fecha
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_inspections');
    }
};
