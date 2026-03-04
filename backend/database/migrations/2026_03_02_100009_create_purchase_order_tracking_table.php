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
        Schema::create('purchase_order_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->onDelete('cascade');
            $table->enum('status', ['pendiente', 'confirmado', 'en_produccion', 'embarcado', 'en_transito', 'aduana', 'entregado']);
            $table->string('tracking_number', 100)->nullable();
            $table->string('carrier', 100)->nullable();
            $table->string('location', 255)->nullable();
            $table->date('estimated_delivery')->nullable();
            $table->date('actual_delivery')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamp('created_at')->nullable();
        });

        DB::statement("ALTER TABLE `purchase_order_tracking` comment 'Tabla para gestionar el seguimiento de las órdenes de compra, incluyendo estado, información de envío y entregas'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_tracking');
    }
};
