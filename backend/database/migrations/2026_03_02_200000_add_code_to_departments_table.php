<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->string('code', 20)->unique()->after('id')->comment('Código único para el departamento');
            $table->boolean('is_active')->default(true)->after('name')->comment('1 para activo, 0 para inactivo');
        });
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn(['code', 'is_active']);
        });
    }
};
