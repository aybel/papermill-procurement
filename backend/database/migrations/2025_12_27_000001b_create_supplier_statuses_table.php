<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('supplier_statuses', function (Blueprint $table) {
            $table->id()->comment('ID autoincremental');
            $table->string('code', 50)->unique()->comment('Código único del estado (active, suspended, inactive)');
            $table->string('name', 100)->comment('Nombre descriptivo del estado');
            $table->string('description', 255)->nullable()->comment('Descripción detallada del estado');
            $table->string('color', 20)->nullable()->comment('Color para UI (success, warning, danger, etc.)');
            $table->boolean('is_active')->default(true)->comment('Indica si el estado está activo y disponible');
            $table->timestamps();
        });

        // Insertar estados iniciales
        DB::table('supplier_statuses')->insert([
            ['code' => 'active', 'name' => 'Activo', 'description' => 'Proveedor activo y operativo', 'color' => 'success', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'suspended', 'name' => 'Suspendido', 'description' => 'Proveedor temporalmente suspendido', 'color' => 'warning', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'inactive', 'name' => 'Inactivo', 'description' => 'Proveedor inactivo o dado de baja', 'color' => 'danger', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_statuses');
    }
};
