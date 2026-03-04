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
        Schema::create('purchase_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('pr_number', 20)->unique()->comment('Formato: PR-YYYY-MM-XXXX');
            $table->enum('requisition_type', ['normal', 'urgente', 'programada', 'reorden'])->default('normal');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('requested_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->foreignId('budget_request_id')->nullable()->constrained('budget_requests')->comment('Vinculación con presupuesto anual');
            $table->enum('priority', ['baja', 'media', 'alta', 'critica'])->default('media');
            $table->date('expected_date')->nullable();
            $table->text('justification')->nullable();
            $table->enum('status', ['borrador', 'pendiente', 'aprobada', 'rechazada', 'en_cotizacion', 'ordenada', 'parcial', 'completada'])->default('borrador');
            $table->decimal('total_estimated', 15, 2)->default(0);
            $table->foreignId('currency_id')->default(1)->constrained('currencies');
            $table->integer('approval_level')->default(1)->comment('Nivel de aprobación requerido');
            $table->timestamp('approval_date')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `purchase_requisitions` comment 'Tabla para gestionar las solicitudes de compra realizadas por los departamentos'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisitions');
    }
};
