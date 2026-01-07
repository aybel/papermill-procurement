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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id()->comment('ID autoincremental');
            $table->string('code', 20)->unique()->comment('Código único del proveedor');
            $table->string('name', 255)->comment('Nombre o razón social del proveedor');
            $table->string('tax_id', 20)->nullable()->comment('RUC, RFC o identificación fiscal');
            $table->foreignId('supplier_type_id')->nullable()->constrained('supplier_types')->comment('FK: Tipo de proveedor (ref: supplier_types.id)');
            $table->foreignId('supplier_status_id')->default(1)->constrained('supplier_statuses')->comment('FK: Estado del proveedor (ref: supplier_statuses.id)');

            // Métricas de desempeño
            $table->decimal('quality_score', 3, 2)->default(0.00)->comment('Puntuación de calidad (0.00 - 1.00)');
            $table->decimal('delivery_score', 3, 2)->default(0.00)->comment('Puntuación de entregas (0.00 - 1.00)');
            //$table->decimal('overall_score', 3, 2)->default(0.00)->comment('Puntuación general (0.00 - 1.00)'); este campo se puede calcular al vuelo

            // Información financiera
            $table->foreignId('payment_terms_id')->default(3)->constrained('payment_terms')->comment('FK: Términos de pago del proveedor (ref: payment_terms.id)');
            $table->foreignId('currency_id')->default(1)->constrained('currencies')->comment('FK: Moneda de operación del proveedor (ref: currencies.id)');
            $table->decimal('credit_limit', 15, 2)->default(0.00)->nullable()->comment('Límite de crédito autorizado');

            // Información adicional
            $table->string('notes', 500)->nullable()->comment('Notas o comentarios adicionales sobre el proveedor');
            $table->boolean('active')->default(1)->comment('Indica si el proveedor está activo o inactivo');
            $table->timestamps();
            $table->softDeletes();

            $table->index('supplier_status_id', 'idx_suppliers_status'); // Índice para búsquedas por estado
            $table->index('supplier_type_id', 'idx_suppliers_type'); // Índice para búsquedas por tipo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
