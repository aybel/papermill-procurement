<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_types', function (Blueprint $table) {
            $table->id()->comment('ID autoincremental');
            $table->string('code', 50)->unique()->comment('Código único del tipo de material');
            $table->string('name', 100)->comment('Nombre descriptivo del tipo');
            $table->string('description', 255)->nullable()->comment('Descripción breve del tipo');
            $table->json('attributes')->nullable()->comment('Metadatos o configuraciones por tipo en formato JSON');
            $table->unsignedSmallInteger('sort_order')->default(0)->comment('Orden sugerido para listados');
            $table->boolean('is_active')->default(true)->comment('Indica si el tipo está activo');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `material_types` comment 'Catálogo de tipos de materiales'");

        Schema::create('units_of_measure', function (Blueprint $table) {
            $table->id()->comment('ID autoincremental');
            $table->string('code', 50)->unique()->comment('Código único de la unidad (ej. kg, m2, pliego)');
            $table->string('name', 100)->comment('Nombre descriptivo de la unidad');
            $table->string('symbol', 20)->nullable()->comment('Símbolo corto (ej. kg, L)');
            $table->string('category', 50)->nullable()->comment('Categoría: weight, volume, length, area, units, etc.');
            $table->decimal('conversion_factor', 18, 6)->default(1)->comment('Factor de conversión respecto a la unidad base de la categoría');
            $table->foreignId('base_unit_id')->nullable()->constrained('units_of_measure')->comment('FK: unidad base de referencia para conversión');
            $table->boolean('is_base_unit')->default(false)->comment('Marca si es la unidad base de su categoría');
            $table->unsignedTinyInteger('decimal_places')->default(2)->comment('Decimales permitidos para capturas');
            $table->string('description', 255)->nullable()->comment('Descripción opcional');
            $table->boolean('is_active')->default(true)->comment('Indica si la unidad está activa');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `units_of_measure` comment 'Catálogo de unidades de medida'");

        Schema::table('materials', function (Blueprint $table) {
            $table->foreignId('material_type_id')
                ->nullable()
                ->after('category_id')
                ->constrained('material_types');

            $table->foreignId('unit_of_measure_id')
                ->nullable()
                ->after('material_type_id')
                ->constrained('units_of_measure');

            $table->dropColumn(['material_type', 'unit_of_measure']);
        });
    }

    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->string('material_type', 50)->nullable()->after('category_id');
            $table->string('unit_of_measure', 20)->after('material_type');
            $table->dropConstrainedForeignId('material_type_id');
            $table->dropConstrainedForeignId('unit_of_measure_id');
        });

        Schema::dropIfExists('units_of_measure');
        Schema::dropIfExists('material_types');
    }
};
