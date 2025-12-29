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
        Schema::create('payment_terms', function (Blueprint $table) {
            $table->id()->comment('ID autoincremental');
            $table->string('code', 20)->unique()->comment('Código único del término de pago (NET30, NET60, etc.)');
            $table->string('name', 100)->comment('Nombre descriptivo del término');
            $table->integer('days')->comment('Número de días para el pago');
            $table->text('description')->nullable()->comment('Descripción detallada del término de pago');
            $table->boolean('is_active')->default(true)->comment('Indica si el término está activo');
            $table->timestamps();

            $table->index('is_active', 'idx_payment_terms_active');
        });

        // Insertar términos de pago comunes
        DB::table('payment_terms')->insert([
            [
                'code' => 'IMMEDIATE',
                'name' => 'Pago Inmediato',
                'days' => 0,
                'description' => 'Pago al recibir la mercancía',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'NET15',
                'name' => 'Neto 15 días',
                'days' => 15,
                'description' => 'Pago a 15 días después de la factura',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'NET30',
                'name' => 'Neto 30 días',
                'days' => 30,
                'description' => 'Pago a 30 días después de la factura',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'NET45',
                'name' => 'Neto 45 días',
                'days' => 45,
                'description' => 'Pago a 45 días después de la factura',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'NET60',
                'name' => 'Neto 60 días',
                'days' => 60,
                'description' => 'Pago a 60 días después de la factura',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'NET90',
                'name' => 'Neto 90 días',
                'days' => 90,
                'description' => 'Pago a 90 días después de la factura',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_terms');
    }
};
