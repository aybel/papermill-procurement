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
        Schema::create('user_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->enum('role', ['viewer', 'manager', 'approver'])->default('viewer')
                ->comment('Rol funcional del usuario en este departamento: viewer=solo lectura, manager=gestión completa, approver=aprobador');
            $table->timestamps();

            // Evitar duplicados: un usuario no puede tener múltiples roles en el mismo departamento
            $table->unique(['user_id', 'department_id']);
        });

        DB::statement("ALTER TABLE `user_departments` comment 'Relación N-N entre usuarios y departamentos para acceso funcional (gestión de compras, presupuestos, etc.)'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_departments');
    }
};
