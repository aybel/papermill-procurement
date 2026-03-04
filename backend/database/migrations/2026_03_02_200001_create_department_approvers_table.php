<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('department_approvers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title', 100)->comment('Cargo del aprobador, ej: Gerente de Producción');
            $table->unsignedTinyInteger('approval_level')->default(1)->comment('Nivel jerárquico de aprobación (1 es el más bajo)');
            $table->decimal('approval_limit', 15, 2)->nullable()->comment('Monto máximo que puede aprobar. Nulo para ilimitado.');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['department_id', 'user_id']);
        });

        DB::statement("ALTER TABLE `department_approvers` comment 'Tabla para gestionar los aprobadores asignados a cada departamento, incluyendo su nivel jerárquico y límites de aprobación'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_approvers');
    }
};
