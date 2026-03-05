<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('resource')->nullable()->after('name');
            $table->string('action')->nullable()->after('resource');
            $table->string('category')->nullable()->after('action');
            $table->text('description')->nullable()->after('category');
            $table->string('icon')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['resource', 'action', 'category', 'description', 'icon']);
        });
    }
};
