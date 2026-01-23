<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('material_types')->insert([
            ['name' => 'Materia Prima', 'description' => 'Materiales base para la fabricación de productos.'],
            ['name' => 'Químico', 'description' => 'Sustancias químicas para procesos industriales.'],
            ['name' => 'Empaque', 'description' => 'Materiales para embalaje y protección.'],
            ['name' => 'Consumible', 'description' => 'Artículos de uso frecuente y reposición.'],
            ['name' => 'Repuesto', 'description' => 'Piezas para mantenimiento y reparación.'],
            ['name' => 'Tinta', 'description' => 'Tintas y colorantes para impresión.'],
            ['name' => 'Aditivo', 'description' => 'Sustancias para modificar propiedades de materiales.'],
            ['name' => 'Herramienta', 'description' => 'Instrumentos para operación y mantenimiento.'],
            ['name' => 'Lubricante', 'description' => 'Aceites y grasas para maquinaria.'],
            ['name' => 'Equipo de Seguridad', 'description' => 'Elementos para protección personal e industrial.'],
        ]);
    }
}
