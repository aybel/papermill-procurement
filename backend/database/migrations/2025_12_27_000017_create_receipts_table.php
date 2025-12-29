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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id()->comment('ID autoincremental');
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->comment('FK: Orden de compra recibida (ref: purchase_orders.id)');
            $table->string('receipt_number', 50)->unique()->comment('Número único de recibo (REC-YYYY-XXXXX)');
            $table->timestamp('received_at')->comment('Fecha y hora de recepción del material');
            $table->foreignId('received_by')->constrained('users')->comment('FK: Usuario que recibió el material (ref: users.id)');
            $table->string('status', 30)->default('pending')->comment('Estado: pending, accepted, rejected, partial');
            $table->text('notes')->nullable()->comment('Observaciones generales de la recepción');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
