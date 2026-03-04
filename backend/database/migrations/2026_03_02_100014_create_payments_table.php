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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number', 20)->unique();
            $table->foreignId('supplier_invoice_id')->constrained('supplier_invoices');
            $table->enum('payment_method', ['transferencia', 'cheque', 'efectivo', 'tarjeta', 'letra']);
            $table->decimal('amount', 15, 4);
            $table->date('payment_date');
            $table->string('reference_number', 100)->nullable()->comment('Número de transferencia/cheque');
            $table->string('bank_account', 100)->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->string('receipt_file', 255)->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['programado', 'procesado', 'confirmado', 'fallido'])->default('programado');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `payments` comment 'Tabla para gestionar los pagos realizados a los proveedores, incluyendo detalles de método de pago, estado del pago y relación con las facturas'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
