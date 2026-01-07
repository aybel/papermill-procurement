<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('supplier_statuses')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('supplier_statuses')->insert([
            ['id' => 1, 'code' => 'ACTIVE', 'name' => 'Activo', 'description' => 'Proveedor aprobado y operativo.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'code' => 'SUSPENDED', 'name' => 'Suspendido', 'description' => 'Proveedor temporalmente inhabilitado para nuevas órdenes.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'code' => 'INACTIVE', 'name' => 'Inactivo', 'description' => 'Proveedor que ya no forma parte de la cadena de suministro.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'code' => 'EVALUATING', 'name' => 'En Evaluación', 'description' => 'Proveedor potencial en proceso de calificación.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'code' => 'REJECTED', 'name' => 'Rechazado', 'description' => 'Proveedor que no cumplió con los criterios de calificación.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
