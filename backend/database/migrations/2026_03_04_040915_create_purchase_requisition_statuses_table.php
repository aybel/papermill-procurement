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
        Schema::create('purchase_requisition_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `purchase_requisition_statuses` comment 'Catálogo de estados para las requisiciones de compra'");

        // Insertar estados iniciales
        DB::table('purchase_requisition_statuses')->insert([
            ['name' => 'Borrador', 'description' => 'La requisición está en proceso de creación y no ha sido enviada.'],
            ['name' => 'Pendiente de Aprobación', 'description' => 'La requisición ha sido enviada y está esperando la aprobación del jefe de departamento.'],
            ['name' => 'Aprobada', 'description' => 'La requisición ha sido aprobada por el jefe de departamento.'],
            ['name' => 'Rechazada', 'description' => 'La requisición ha sido rechazada.'],
            ['name' => 'En Proceso de Compra', 'description' => 'La requisición está siendo procesada por el departamento de compras.'],
            ['name' => 'Completada', 'description' => 'Todos los artículos de la requisición han sido comprados y recibidos.'],
            ['name' => 'Cancelada', 'description' => 'La requisición ha sido cancelada.'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisition_statuses');
    }
};
