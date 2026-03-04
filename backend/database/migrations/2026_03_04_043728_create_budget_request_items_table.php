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
        Schema::create('budget_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_request_id')->constrained('budget_requests')->onDelete('cascade');
            $table->foreignId('material_id')->constrained('materials');
            $table->decimal('quantity', 15, 4)->comment('Cantidad solicitada para este ítem');
            $table->decimal('estimated_unit_price', 15, 4)->comment('Precio unitario estimado para este ítem');
            $table->text('technical_specifications')->nullable()->comment('Especificaciones técnicas para este ítem');
            $table->text('quality_requirements')->nullable()->comment('Requisitos de calidad específicos para este ítem');
            $table->text('justification')->nullable()->comment('Justificación para la inclusión de este ítem en la solicitud de presupuesto');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `budget_request_items` comment 'Items detallados para cada solicitud de presupuesto anual'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_request_items');
    }
};
