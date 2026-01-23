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
        Schema::create('supplier_contacts', function (Blueprint $table) {
            $table->id()->comment('ID autoincremental');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade')->comment('FK: Proveedor al que pertenece el contacto (ref: suppliers.id)');
            $table->string('name', 255)->comment('Nombre completo del contacto');
            $table->string('email', 255)->nullable()->comment('Email del contacto');
            $table->string('phone', 20)->nullable()->comment('Teléfono del contacto');
            $table->string('mobile', 20)->nullable()->comment('Celular del contacto');
            $table->string('position', 100)->nullable()->comment('Cargo o posición del contacto');
            $table->string('department', 100)->nullable()->comment('Departamento del contacto (ventas, compras, etc.)');
            $table->boolean('primary')->default(false)->comment('Indica si es el contacto principal');
            $table->boolean('active')->default(true)->comment('Indica si el contacto está activo');
            $table->text('notes')->nullable()->comment('Notas adicionales sobre el contacto');
            $table->timestamps();

            $table->index('supplier_id', 'idx_supplier_contacts_supplier');
            $table->index('primary', 'idx_supplier_contacts_primary');
            // Si existía un índice para is_active, actualizarlo a active si es necesario
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_contacts');
    }
};
