<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('semantic_key')->unique()->nullable();
            $table->string('display_name')->comment('Nombre a mostrar en el menú');
            $table->string('route_name')->nullable()->comment('Nombre de la ruta, no URL');
            $table->string('semantic_icon')->nullable()->comment('Icono semántico, por ejemplo: "supplier", "dashboard", etc.');
            $table->enum('semantic_type', ['header', 'module', 'group', 'link'])->default('link')->comment('Tipo semántico del elemento del menú');
            $table->foreignId('permission_id')->nullable()->constrained('permissions')->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->cascadeOnDelete();
            $table->integer('order')->default(0);
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['order', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
