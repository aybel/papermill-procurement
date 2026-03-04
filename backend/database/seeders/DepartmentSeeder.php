<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departments')->insert([
            ['code' => 'PROD', 'name' => 'Producción', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'MANT', 'name' => 'Mantenimiento', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'ADMIN', 'name' => 'Administración', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'QA', 'name' => 'Control de Calidad', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'COMP', 'name' => 'Compras', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'VENT', 'name' => 'Ventas', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'LOG', 'name' => 'Logística y Almacén', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'IT', 'name' => 'Tecnologías de la Información', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'RRHH', 'name' => 'Recursos Humanos', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
