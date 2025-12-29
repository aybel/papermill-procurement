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
        Schema::create('purchase_requisitions', function (Blueprint $table) {
            $table->id()->comment('ID autoincremental');
            $table->string('requisition_number', 50)->unique()->comment('Número único de requisición (REQ-YYYY-XXXXX)');
            $table->string('department', 100)->comment('Departamento que solicita (producción, mantenimiento, etc.)');
            $table->foreignId('requested_by')->constrained('users')->comment('FK: Usuario que solicita (ref: users.id)');

            // Flujo de estado
            $table->string('status', 30)->default('draft')->comment('Estado: draft, pending_approval, approved, rejected, converted, cancelled');

            // Cadena de aprobación
            $table->foreignId('approver_id')->nullable()->constrained('users')->comment('FK: Usuario aprobador (ref: users.id)');
            $table->timestamp('approved_at')->nullable()->comment('Fecha y hora de aprobación');
            $table->text('rejection_reason')->nullable()->comment('Motivo de rechazo si aplica');

            $table->string('priority', 20)->default('medium')->comment('Prioridad: low, medium, high, urgent');
            $table->date('required_date')->comment('Fecha en que se requiere el material');

            $table->decimal('total_estimated_cost', 15, 2)->default(0)->comment('Costo total estimado de la requisición');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisitions');
    }
};
