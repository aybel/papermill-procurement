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
        Schema::create('budget_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('budget_category_id')->constrained('budget_categories');
            $table->year('year');
            $table->decimal('assigned_amount', 15, 4);
            $table->text('justification')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->unique(['department_id', 'budget_category_id', 'year'], 'unique_dept_category_year');
        });
        // Agrega el comentario a la tabla
        DB::statement("ALTER TABLE `budget_assignments` comment 'Tabla para almacenar las asignaciones de presupuesto a los departamentos por categoría y año'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_assignments');
    }
};
