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
        Schema::create('supplier_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 100);
            $table->foreignId('purchase_order_id')->constrained('purchase_orders');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->foreignId('currency_id')->default(1)->constrained('currencies');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->decimal('subtotal', 15, 4);
            $table->decimal('tax_amount', 15, 4)->default(0);
            $table->decimal('total_amount', 15, 4);
            $table->decimal('amount_paid', 15, 4)->default(0);
            $table->decimal('balance_due', 15, 4);
            $table->enum('payment_status', ['pendiente', 'parcial', 'pagada', 'vencida', 'disputa'])->default('pendiente');
            $table->string('invoice_file', 255)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['supplier_id', 'invoice_number'], 'unique_supplier_invoice');
        });

        DB::statement("ALTER TABLE `supplier_invoices` comment 'Tabla para gestionar las facturas recibidas de los proveedores, incluyendo detalles de pago, estado de la factura y relación con las órdenes de compra'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_invoices');
    }
};
