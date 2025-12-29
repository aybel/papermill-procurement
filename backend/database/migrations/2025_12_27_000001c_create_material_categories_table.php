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
        Schema::create('material_categories', function (Blueprint $table) {
            $table->id()->comment('ID autoincremental');
            $table->string('name', 100)->comment('Nombre de la categoría');
            $table->foreignId('parent_id')->nullable()->constrained('material_categories')->onDelete('set null')->comment('FK: Categoría padre para estructura jerárquica (ref: material_categories.id)');
            $table->json('attributes')->nullable()->comment('Atributos personalizados en formato JSON');
            $table->timestamps();
            $table->softDeletes();

            $table->index('parent_id', 'idx_material_categories_parent'); // Índice para búsquedas por categoría padre
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_categories');
    }
};
