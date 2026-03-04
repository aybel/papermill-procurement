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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number', 20)->unique()->comment('RCP-YYYY-MM-XXXX');
            $table->foreignId('purchase_order_id')->constrained('purchase_orders');
            $table->foreignId('received_by')->constrained('users');
            $table->date('receipt_date');
            $table->enum('receipt_type', ['completa', 'parcial', 'sobrante', 'muestra'])->default('completa');
            $table->string('warehouse_location', 100)->nullable();
            $table->string('delivery_note_number', 100)->nullable()->comment('Número de guía/remisión');
            $table->string('delivery_note_image', 255)->nullable();
            $table->string('carrier_info', 255)->nullable();
            $table->string('vehicle_plate', 20)->nullable();
            $table->string('driver_name', 100)->nullable();
            $table->string('driver_id', 50)->nullable();
            $table->decimal('temperature', 5, 2)->nullable()->comment('Para materiales sensibles');
            $table->decimal('humidity', 5, 2)->nullable()->comment('Control ambiental');
            $table->text('notes')->nullable();
            $table->enum('status', ['recibido', 'en_inspeccion', 'aprobado', 'rechazado', 'parcial'])->default('recibido');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `receipts` comment 'Tabla para gestionar los recibos de materiales asociados a las órdenes de compra, incluyendo detalles de recepción, inspección y estado del material'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
