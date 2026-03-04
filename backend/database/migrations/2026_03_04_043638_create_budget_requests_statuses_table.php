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
        Schema::create('budget_request_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `budget_request_statuses` comment 'Catálogo de estados para las solicitudes de presupuesto'");

        // Insertar estados iniciales
        DB::table('budget_request_statuses')->insert([
            ['name' => 'Borrador', 'description' => 'La solicitud de presupuesto está en creación.'],
            ['name' => 'Pendiente de Aprobación', 'description' => 'La solicitud está esperando aprobación.'],
            ['name' => 'Aprobada', 'description' => 'La solicitud ha sido aprobada.'],
            ['name' => 'Rechazada', 'description' => 'La solicitud ha sido rechazada.'],
            ['name' => 'En Revisión', 'description' => 'La solicitud está siendo revisada por finanzas.'],
            ['name' => 'Cerrada', 'description' => 'El ciclo de la solicitud de presupuesto ha finalizado.'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_request_statuses');
    }
};
