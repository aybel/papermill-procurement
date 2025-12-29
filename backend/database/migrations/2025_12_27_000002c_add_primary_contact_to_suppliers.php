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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->foreignId('primary_contact_id')->nullable()->after('supplier_status_id')->constrained('supplier_contacts')->onDelete('set null')->comment('FK: Contacto principal del proveedor (ref: supplier_contacts.id)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropForeign(['primary_contact_id']);
            $table->dropColumn('primary_contact_id');
        });
    }
};
