<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id()->comment('ID autoincremental');
            $table->string('sku', 50)->unique()->comment('Código SKU único del material');
            $table->string('name', 255)->comment('Nombre del material');
            $table->text('description')->nullable()->comment('Descripción detallada del material');

            // Clasificación
            $table->foreignId('category_id')->nullable()->constrained('material_categories')->comment('FK: Categoría del material (ref: material_categories.id)');
            $table->foreignId('material_type_id')->constrained('material_types')->comment('FK: Tipo de material (ref: material_types.id)');
            $table->string('unit_of_measure', 20)->comment('Unidad de medida (kg, ton, rollo, litro, etc.)');

            // Gestión de inventario
            $table->decimal('current_stock', 15, 4)->default(0)->comment('Stock actual disponible');
            $table->decimal('min_stock', 15, 4)->default(0)->comment('Stock mínimo requerido');
            $table->decimal('max_stock', 15, 4)->default(0)->comment('Stock máximo permitido');
            $table->decimal('safety_stock', 15, 4)->default(0)->comment('Stock de seguridad');
            $table->decimal('reorder_point', 15, 4)->storedAs('min_stock + safety_stock')->comment('Punto de reorden (calculado automáticamente)');

            // Costos
            $table->decimal('avg_unit_cost', 15, 4)->default(0)->comment('Costo promedio por unidad');
            $table->decimal('last_purchase_price', 15, 4)->nullable()->comment('Último precio de compra');
            $table->foreignId('currency_id')->default(1)->constrained('currencies')->comment('FK: Moneda del precio (ref: currencies.id)');

            // Especificaciones para papelera
            $table->decimal('grammage', 10, 2)->nullable()->comment('Gramaje en g/m²');
            $table->decimal('width', 10, 2)->nullable()->comment('Ancho en cm');
            $table->decimal('length', 10, 2)->nullable()->comment('Largo en metros');
            $table->string('color', 50)->nullable()->comment('Color del material');

            $table->timestamps();

            $table->index('sku', 'idx_materials_sku'); // Índice para búsquedas por SKU
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
