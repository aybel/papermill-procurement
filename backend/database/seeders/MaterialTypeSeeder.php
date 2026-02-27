<?php
// database/seeders/MaterialTypeSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'code' => 'raw_material',
                'name' => 'Materia Prima',
                'description' => 'Materiales base para producción de papel y cartón',
                'attributes' => json_encode([
                    'control_humedad' => true,
                    'ficha_tecnica' => true,
                    'origen' => ['nacional', 'importado']
                ]),
                'sort_order' => 10
            ],
            [
                'code' => 'chemical',
                'name' => 'Insumo Químico',
                'description' => 'Productos químicos para proceso productivo',
                'attributes' => json_encode([
                    'hoja_seguridad' => true,
                    'control_lote' => true,
                    'fecha_vencimiento' => true,
                    'clase_peligro' => ['corrosivo', 'inflamable', 'toxico', 'no_peligroso']
                ]),
                'sort_order' => 20
            ],
            [
                'code' => 'packaging',
                'name' => 'Material de Empaque',
                'description' => 'Materiales para fabricación de empaques y cajas',
                'attributes' => json_encode([
                    'dimensiones' => true,
                    'gramaje' => true,
                    'acabados' => ['brillante', 'mate', 'laminado']
                ]),
                'sort_order' => 30
            ],
            [
                'code' => 'consumable',
                'name' => 'Consumible',
                'description' => 'Insumos de consumo general en planta',
                'attributes' => json_encode([
                    'tipo' => ['limpieza', 'mantenimiento', 'oficina']
                ]),
                'sort_order' => 40
            ],
            [
                'code' => 'spare_part',
                'name' => 'Refacción',
                'description' => 'Partes y refacciones para maquinaria',
                'attributes' => json_encode([
                    'equipo_asociado' => true,
                    'vida_util' => true,
                    'criticidad' => ['alta', 'media', 'baja']
                ]),
                'sort_order' => 50
            ],
            [
                'code' => 'finished_product',
                'name' => 'Producto Terminado',
                'description' => 'Productos finales para venta',
                'attributes' => json_encode([
                    'presentacion' => true,
                    'codigo_barras' => true
                ]),
                'sort_order' => 60
            ]
        ];

        foreach ($types as $type) {
            DB::table('material_types')->updateOrInsert(
                ['code' => $type['code']],
                $type
            );
        }
    }
}
