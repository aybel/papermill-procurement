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
        Schema::create('rfqs', function (Blueprint $table) {
            $table->id();
            $table->string('rfq_number', 20)->unique()->comment('RFQ-YYYY-MM-XXXX');
            $table->foreignId('purchase_requisition_id')->constrained('purchase_requisitions');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->enum('status', ['borrador', 'enviada', 'recibiendo', 'evaluando', 'adjudicada', 'cancelada'])->default('borrador');
            $table->dateTime('submission_deadline');
            $table->text('shipping_terms')->nullable();
            $table->foreignId('payment_terms_id')->nullable()->constrained('payment_terms');
            $table->text('delivery_requirements')->nullable();
            $table->text('quality_standards')->nullable();
            $table->dateTime('bid_opening_date')->nullable();
            $table->enum('evaluation_method', ['menor_precio', 'mejor_valor', 'puntaje_ponderado'])->default('menor_precio');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `rfqs` comment 'Tabla para gestionar las solicitudes de cotización (RFQ) asociadas a las solicitudes de compra, incluyendo detalles de envío, pago y evaluación'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfqs');
    }
};
