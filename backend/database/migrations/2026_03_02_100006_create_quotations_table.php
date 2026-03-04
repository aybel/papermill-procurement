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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_number', 50)->comment('Número de cotización del proveedor');
            $table->foreignId('rfq_id')->constrained('rfqs');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->foreignId('rfq_supplier_id')->nullable()->constrained('rfq_suppliers');
            $table->foreignId('currency_id')->default(1)->constrained('currencies');
            $table->timestamp('submitted_at');
            $table->date('valid_until');
            $table->foreignId('payment_terms_id')->nullable()->constrained('payment_terms');
            $table->integer('delivery_time_days')->comment('Tiempo de entrega en días');
            $table->decimal('shipping_cost', 15, 4)->default(0);
            $table->decimal('tax_amount', 15, 4)->default(0);
            $table->decimal('total_amount', 15, 4);
            $table->text('technical_specs')->nullable()->comment('Especificaciones técnicas ofrecidas');
            $table->text('warranty_terms')->nullable();
            $table->enum('status', ['recibida', 'evaluada', 'seleccionada', 'rechazada'])->default('recibida');
            $table->decimal('evaluation_score', 5, 2)->nullable()->comment('Puntaje de evaluación (0-100)');
            $table->text('evaluation_notes')->nullable();
            $table->foreignId('evaluated_by')->nullable()->constrained('users');
            $table->timestamp('evaluated_at')->nullable();
            $table->string('document_path', 255)->nullable()->comment('Ruta al PDF de la cotización');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `quotations` comment 'Tabla para gestionar las cotizaciones recibidas de los proveedores en respuesta a las RFQs, incluyendo detalles técnicos, términos de pago y evaluación'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
