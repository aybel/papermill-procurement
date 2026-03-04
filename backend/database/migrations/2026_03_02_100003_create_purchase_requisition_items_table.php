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
        Schema::create('purchase_requisition_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_requisition_id')->constrained('purchase_requisitions')->onDelete('cascade');
            $table->foreignId('material_id')->constrained('materials');
            $table->decimal('quantity', 15, 4);
            $table->text('specifications')->nullable()->comment('Requerimientos técnicos específicos');
            $table->text('quality_requirements')->nullable()->comment('Requisitos de calidad');
            $table->date('delivery_date_required')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `purchase_requisition_items` comment 'Tabla para gestionar los ítems de cada solicitud de compra, incluyendo detalles técnicos y estado de cada ítem'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisition_items');
    }
};
