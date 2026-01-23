<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialCategorySeeder extends Seeder
{
    public function run(): void
    {
        $nombres = [
            'Celulosa y Fibras',
            'Químicos',
            'Empaques',
            'Consumibles',
            'Repuestos',
            'Tintas y Colorantes',
            'Aditivos',
            'Herramientas',
            'Lubricantes',
            'Equipos de Seguridad'
        ];
        $descs = [
            'Materias primas para la fabricación de papel y cartón.',
            'Productos químicos para procesos industriales y de blanqueo.',
            'Materiales para embalaje y protección de productos.',
            'Artículos de uso diario en planta y oficina.',
            'Piezas de repuesto para maquinaria y equipos.',
            'Tintas, pigmentos y colorantes para impresión y acabado.',
            'Aditivos para mejorar propiedades del papel.',
            'Herramientas manuales y eléctricas para mantenimiento.',
            'Aceites y grasas para lubricación de maquinaria.',
            'Equipos y accesorios para seguridad industrial.'
        ];
        $categorias = [];
        for ($i = 0; $i < 10; $i++) {
            $categorias[] = [
                'name' => $nombres[$i],
                'parent_id' => null,
                'attributes' => json_encode(['descripcion' => $descs[$i]]),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('material_categories')->insert($categorias);
    }
}
