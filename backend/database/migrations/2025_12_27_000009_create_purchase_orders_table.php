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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id()->comment('ID autoincremental');
            $table->string('po_number', 50)->unique()->comment('Número único de orden de compra (PO-YYYY-XXXXX)');
            $table->foreignId('supplier_id')->constrained('suppliers')->comment('FK: Proveedor (ref: suppliers.id)');
            $table->foreignId('requisition_id')->nullable()->constrained('purchase_requisitions')->comment('FK: Requisición origen (ref: purchase_requisitions.id)');

            // Información financiera
            $table->foreignId('currency_id')->default(1)->constrained('currencies')->comment('FK: Moneda de la orden (ref: currencies.id)');
            $table->decimal('subtotal', 15, 2)->default(0)->comment('Subtotal antes de impuestos');
            $table->decimal('tax', 15, 2)->default(0)->comment('Monto de impuestos');
            $table->decimal('shipping_cost', 15, 2)->default(0)->comment('Costo de envío');
            $table->decimal('total_amount', 15, 2)->default(0)->comment('Monto total de la orden');

            // Fechas
            $table->date('issue_date')->comment('Fecha de emisión de la orden');
            $table->date('expected_delivery')->comment('Fecha esperada de entrega');
            $table->date('actual_delivery')->nullable()->comment('Fecha real de entrega');

            // Estado
            $table->string('status', 30)->default('draft')->comment('Estado: draft, sent, confirmed, partial_received, completed, cancelled');

            // Términos y condiciones
            $table->foreignId('payment_terms_id')->default(3)->constrained('payment_terms')->comment('FK: Términos de pago (ref: payment_terms.id)');
            $table->text('delivery_terms')->nullable()->comment('Condiciones de entrega');

            $table->timestamps();

            $table->index('status', 'idx_purchase_orders_status'); // Índice para búsquedas por estado
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
