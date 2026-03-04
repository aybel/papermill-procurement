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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id()->comment('ID autoincremental');
            $table->string('code', 3)->unique()->comment('Código ISO de la moneda (USD, EUR, MXN, etc.)');
            $table->string('name', 100)->comment('Nombre completo de la moneda');
            $table->string('symbol', 10)->comment('Símbolo de la moneda ($, €, etc.)');
            $table->decimal('exchange_rate', 12, 6)->default(1.000000)->comment('Tipo de cambio respecto a la moneda base');
            $table->boolean('is_base')->default(false)->comment('Indica si es la moneda base del sistema');
            $table->boolean('is_active')->default(true)->comment('Indica si la moneda está activa');
            $table->timestamps();

            $table->index('is_active', 'idx_currencies_active');
        });

        DB::statement("ALTER TABLE `currencies` comment 'Catálogo de monedas'");

        // Insertar monedas comunes
        DB::table('currencies')->insert([
            [
                'code' => 'USD',
                'name' => 'Dólar Estadounidense',
                'symbol' => '$',
                'exchange_rate' => 1.000000,
                'is_base' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'EUR',
                'name' => 'Euro',
                'symbol' => '€',
                'exchange_rate' => 1.100000,
                'is_base' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'MXN',
                'name' => 'Peso Mexicano',
                'symbol' => '$',
                'exchange_rate' => 0.050000,
                'is_base' => false,
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
        Schema::dropIfExists('currencies');
    }
};
