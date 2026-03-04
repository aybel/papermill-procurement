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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number', 20)->unique()->comment('PO-YYYY-MM-XXXX');
            $table->foreignId('quotation_id')->nullable()->constrained('quotations');
            $table->foreignId('rfq_id')->nullable()->constrained('rfqs');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->foreignId('currency_id')->default(1)->constrained('currencies');
            $table->foreignId('payment_terms_id')->nullable()->constrained('payment_terms');
            $table->string('shipping_method', 100)->nullable();
            $table->text('shipping_terms')->nullable();
            $table->string('incoterm', 50)->nullable()->comment('EXW, FOB, CIF, etc.');
            $table->foreignId('requested_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->integer('approval_level')->default(1);
            $table->decimal('subtotal', 15, 4);
            $table->decimal('discount_total', 15, 4)->default(0);
            $table->decimal('tax_total', 15, 4)->default(0);
            $table->decimal('shipping_cost', 15, 4)->default(0);
            $table->decimal('total_amount', 15, 4);
            $table->date('expected_delivery_date')->nullable();
            $table->text('delivery_address')->nullable();
            $table->text('special_instructions')->nullable();
            $table->text('quality_requirements')->nullable();
            $table->enum('status', [
                'borrador',
                'pendiente_aprobacion',
                'aprobada',
                'rechazada',
                'enviada',
                'confirmada',
                'en_produccion',
                'enviada_parcial',
                'completada',
                'cancelada',
                'facturada'
            ])->default('borrador');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('supplier_confirmation_at')->nullable();
            $table->string('supplier_po_number', 100)->nullable()->comment('Número de orden del proveedor');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `purchase_orders` comment 'Tabla para gestionar las órdenes de compra generadas a partir de las cotizaciones seleccionadas, incluyendo detalles de envío, pago y estado de la orden'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
