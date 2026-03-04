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
        Schema::create('rfq_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rfq_id')->constrained('rfqs');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->timestamp('invitation_sent_at')->nullable();
            $table->timestamp('invitation_accepted_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->enum('status', ['invitado', 'aceptado', 'declinado', 'no_respondio', 'cotizo'])->default('invitado');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['rfq_id', 'supplier_id'], 'unique_rfq_supplier');
        });

        DB::statement("ALTER TABLE `rfq_suppliers` comment 'Tabla para gestionar la relación entre RFQs y proveedores invitados, incluyendo el estado de la invitación y la cotización'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfq_suppliers');
    }
};
