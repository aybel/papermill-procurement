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
        Schema::create('supplier_types', function (Blueprint $table) {
            $table->id()->comment('ID autoincremental');
            $table->string('code', 50)->unique()->comment('Código único del tipo (raw_material, packaging, etc.)');
            $table->string('name', 100)->comment('Nombre descriptivo del tipo de proveedor');
            $table->string('description', 255)->nullable()->comment('Descripción detallada del tipo');
            $table->boolean('active')->default(true)->comment('Indica si el tipo está activo y disponible');
            $table->timestamps();
        });

        // Insertar tipos iniciales
        DB::table('supplier_types')->insert([
            ['code' => 'raw_material', 'name' => 'Materia Prima', 'description' => 'Proveedores de materia prima', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'packaging', 'name' => 'Empaque', 'description' => 'Proveedores de materiales de empaque', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'chemical', 'name' => 'Químicos', 'description' => 'Proveedores de productos químicos', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'service', 'name' => 'Servicios', 'description' => 'Proveedores de servicios', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'equipment', 'name' => 'Equipamiento', 'description' => 'Proveedores de equipos y maquinaria', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_types');
    }
};
