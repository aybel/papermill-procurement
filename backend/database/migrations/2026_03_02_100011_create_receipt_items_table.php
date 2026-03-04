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
        Schema::create('receipt_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receipt_id')->constrained('receipts')->onDelete('cascade');
            $table->foreignId('purchase_order_item_id')->constrained('purchase_order_items');
            $table->foreignId('material_id')->constrained('materials');
            $table->decimal('quantity_ordered', 15, 4);
            $table->decimal('quantity_received', 15, 4);
            $table->decimal('quantity_accepted', 15, 4)->nullable();
            $table->decimal('quantity_rejected', 15, 4)->nullable();
            $table->foreignId('unit_of_measure_id')->constrained('units_of_measure');
            $table->string('batch_number', 100)->nullable();
            $table->date('manufacturing_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('lot_number', 100)->nullable();
            $table->string('warehouse_location', 100)->nullable();
            $table->text('storage_conditions')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `receipt_items` comment 'Tabla para gestionar los ítems de cada recibo de materiales, incluyendo detalles de cantidad, estado de aceptación y datos logísticos asociados'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_items');
    }
};
