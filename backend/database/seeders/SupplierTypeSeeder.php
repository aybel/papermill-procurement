<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Desactiva la revisión de claves foráneas para permitir el truncado
        Schema::disableForeignKeyConstraints();

        // Vacía la tabla antes de llenarla
        DB::table('supplier_types')->truncate();

        // Reactiva la revisión de claves foráneas
        Schema::enableForeignKeyConstraints();

        DB::table('supplier_types')->insert([
            ['id' => 1, 'code' => 'RAW_MAT', 'name' => 'Materia Prima', 'description' => 'Proveedores de insumos directos para producción.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'code' => 'PACK', 'name' => 'Empaque', 'description' => 'Proveedores de materiales para embalaje y empaque.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'code' => 'CHEM', 'name' => 'Químicos', 'description' => 'Proveedores de productos químicos para el proceso.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'code' => 'SERV', 'name' => 'Servicios', 'description' => 'Proveedores de servicios como mantenimiento, logística, etc.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'code' => 'EQUIP', 'name' => 'Equipamiento y Repuestos', 'description' => 'Proveedores de maquinaria, equipos y refacciones.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'code' => 'INDIRECT', 'name' => 'Indirectos', 'description' => 'Proveedores de bienes y servicios no relacionados directamente con la producción (ej. oficina).', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
