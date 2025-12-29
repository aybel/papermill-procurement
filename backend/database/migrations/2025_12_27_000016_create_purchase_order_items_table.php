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
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id()->comment('ID autoincremental');
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->onDelete('cascade')->comment('FK: Orden de compra (ref: purchase_orders.id)');
            $table->foreignId('material_id')->constrained('materials')->comment('FK: Material solicitado (ref: materials.id)');

            $table->decimal('quantity', 15, 4)->comment('Cantidad solicitada');
            $table->decimal('unit_price', 15, 4)->comment('Precio unitario acordado');
            $table->decimal('total_price', 15, 4)->storedAs('quantity * unit_price')->comment('Precio total (calculado automáticamente)');

            // Seguimiento de recepción
            $table->decimal('received_quantity', 15, 4)->default(0)->comment('Cantidad recibida hasta el momento');
            $table->decimal('rejected_quantity', 15, 4)->default(0)->comment('Cantidad rechazada en control de calidad');

            $table->text('notes')->nullable()->comment('Notas adicionales sobre el ítem');

            $table->timestamps();

            $table->index('purchase_order_id', 'idx_purchase_order_items_po'); // Índice para búsquedas por orden
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
