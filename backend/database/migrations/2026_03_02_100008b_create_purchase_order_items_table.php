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
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->onDelete('cascade');
            $table->foreignId('purchase_requisition_item_id')->nullable()->constrained('purchase_requisition_items');
            $table->foreignId('quotation_item_id')->nullable()->constrained('quotation_items');
            $table->foreignId('material_id')->constrained('materials');

            $table->decimal('quantity', 15, 4);
            $table->decimal('unit_price', 15, 4);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('total_price', 15, 4);

            $table->decimal('quantity_received', 15, 4)->default(0);
            $table->decimal('quantity_rejected', 15, 4)->default(0);

            $table->date('expected_delivery_date')->nullable();
            $table->enum('status', ['pendiente', 'parcialmente_recibido', 'recibido_completo', 'cancelado'])->default('pendiente');

            $table->text('notes')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `purchase_order_items` comment 'Tabla para gestionar los ítems de cada orden de compra, incluyendo detalles de precio, impuestos, estado de recepción y relación con requisiciones y cotizaciones'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
