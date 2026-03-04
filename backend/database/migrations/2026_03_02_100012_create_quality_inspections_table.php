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
        Schema::create('quality_inspections', function (Blueprint $table) {
            $table->id();
            $table->string('inspection_number', 20)->unique();
            $table->foreignId('receipt_item_id')->constrained('receipt_items');
            $table->foreignId('inspected_by')->constrained('users');
            $table->timestamp('inspected_at');
            $table->enum('inspection_type', ['visual', 'dimensional', 'fisico', 'quimico', 'microbiologico']);

            // Para papeles/cartones
            $table->decimal('grammage_test', 10, 2)->nullable()->comment('g/m² medido');
            $table->boolean('grammage_compliance')->nullable();
            $table->decimal('thickness_test', 10, 2)->nullable()->comment('micras/μm');
            $table->boolean('thickness_compliance')->nullable();
            $table->decimal('brightness_test', 5, 2)->nullable()->comment('ISO brightness %');
            $table->boolean('brightness_compliance')->nullable();
            $table->decimal('moisture_test', 5, 2)->nullable()->comment('% humedad');
            $table->boolean('moisture_compliance')->nullable();
            $table->decimal('smoothness_test', 10, 2)->nullable()->comment('ml/min');
            $table->boolean('smoothness_compliance')->nullable();
            $table->decimal('tear_resistance_test', 10, 2)->nullable()->comment('mN');
            $table->boolean('tear_compliance')->nullable();

            $table->integer('sample_size')->nullable();
            $table->integer('defects_found')->nullable();
            $table->text('defect_description')->nullable();
            $table->json('photos')->nullable()->comment('Array de rutas de fotos');
            $table->enum('result', ['aprobado', 'aprobado_condicional', 'rechazado', 'cuarentena']);
            $table->text('rejection_cause')->nullable();
            $table->text('corrective_actions')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `quality_inspections` comment 'Tabla para gestionar las inspecciones de calidad realizadas a los ítems recibidos, incluyendo resultados de pruebas específicas para papeles/cartones y detalles de defectos encontrados'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_inspections');
    }
};
