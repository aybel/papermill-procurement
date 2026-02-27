<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\MaterialType;
use App\Models\UnitOfMeasure;
use Illuminate\Support\Str;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener categorías para asignar materiales
        $categorias = MaterialCategory::with('parent')->get();

        // Mapeo de categorías por nombre para fácil acceso
        $catMap = [];
        foreach ($categorias as $cat) {
            $catMap[$cat->name] = $cat;
        }

        $typeMap = MaterialType::pluck('id', 'code');
        $uomMap = UnitOfMeasure::pluck('id', 'code');

        // Materiales para Pastas y Fibras
        $materiales = [
            // Pastas y Fibras
            [
                'sku' => 'PULP-BLQ-001',
                'name' => 'Pasta Química Blanqueada de Eucalipto',
                'description' => 'Pasta celulósica de fibra corta, blanqueada ECF, ideal para papeles de impresión y escritura',
                'category_name' => 'Pastas y Fibras',
                'material_type' => 'raw_material',
                'unit_of_measure' => 'ton',
                'current_stock' => 250.0000,
                'min_stock' => 100.0000,
                'max_stock' => 500.0000,
                'safety_stock' => 50.0000,
                'avg_unit_cost' => 850.0000,
                'last_purchase_price' => 845.5000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => null
            ],
            [
                'sku' => 'PULP-PNB-002',
                'name' => 'Pasta Química Sin Blanquear de Pino',
                'description' => 'Pasta kraft de fibra larga, alta resistencia, para papeles de empaque',
                'category_name' => 'Pastas y Fibras',
                'material_type' => 'raw_material',
                'unit_of_measure' => 'ton',
                'current_stock' => 180.0000,
                'min_stock' => 80.0000,
                'max_stock' => 400.0000,
                'safety_stock' => 40.0000,
                'avg_unit_cost' => 720.5000,
                'last_purchase_price' => 715.0000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => null
            ],

            // Papeles Reciclados
            [
                'sku' => 'REC-OCC-001',
                'name' => 'Papel Reciclado OCC (Old Corrugated Containers)',
                'description' => 'Cajas de cartón corrugado post-industriales clasificadas',
                'category_name' => 'Papeles Reciclados',
                'material_type' => 'raw_material',
                'unit_of_measure' => 'ton',
                'current_stock' => 320.0000,
                'min_stock' => 150.0000,
                'max_stock' => 600.0000,
                'safety_stock' => 75.0000,
                'avg_unit_cost' => 350.0000,
                'last_purchase_price' => 345.0000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => null
            ],

            // Aditivos para Producción
            [
                'sku' => 'CHEM-RET-001',
                'name' => 'Agente de Retención Catiónico',
                'description' => 'Polímero de alta masa molecular para mejorar retención en máquina de papel',
                'category_name' => 'Aditivos para Producción',
                'material_type' => 'chemical',
                'unit_of_measure' => 'kg',
                'current_stock' => 1500.0000,
                'min_stock' => 500.0000,
                'max_stock' => 3000.0000,
                'safety_stock' => 200.0000,
                'avg_unit_cost' => 4.5000,
                'last_purchase_price' => 4.3500,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => null
            ],
            [
                'sku' => 'CHEM-ENC-002',
                'name' => 'Encolante Interno AKD',
                'description' => 'Agente de encolado para resistencia a líquidos en papeles',
                'category_name' => 'Aditivos para Producción',
                'material_type' => 'chemical',
                'unit_of_measure' => 'kg',
                'current_stock' => 800.0000,
                'min_stock' => 300.0000,
                'max_stock' => 2000.0000,
                'safety_stock' => 150.0000,
                'avg_unit_cost' => 3.8000,
                'last_purchase_price' => 3.7500,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => null
            ],

            // Cartón Corrugado
            [
                'sku' => 'CART-SC-001',
                'name' => 'Cartón Corrugado Sencillo Flauta C',
                'description' => 'Hoja de cartón corrugado sencillo, flauta C, test 200',
                'category_name' => 'Cartón Corrugado',
                'material_type' => 'packaging',
                'unit_of_measure' => 'pliego',
                'current_stock' => 5000.0000,
                'min_stock' => 2000.0000,
                'max_stock' => 10000.0000,
                'safety_stock' => 500.0000,
                'avg_unit_cost' => 2.5000,
                'last_purchase_price' => 2.4500,
                'currency_id' => 1,
                'grammage' => 450.00,
                'width' => 100.00,
                'length' => 150.00,
                'color' => 'kraft'
            ],

            // Papeles Kraft
            [
                'sku' => 'KRAFT-NAT-001',
                'name' => 'Papel Kraft Natural 150g',
                'description' => 'Papel kraft natural para fabricación de bolsas y empaques',
                'category_name' => 'Papeles Kraft',
                'material_type' => 'packaging',
                'unit_of_measure' => 'kg',
                'current_stock' => 2500.0000,
                'min_stock' => 1000.0000,
                'max_stock' => 5000.0000,
                'safety_stock' => 300.0000,
                'avg_unit_cost' => 1.8000,
                'last_purchase_price' => 1.7500,
                'currency_id' => 1,
                'grammage' => 150.00,
                'width' => 120.00,
                'length' => null,
                'color' => 'natural'
            ],
            [
                'sku' => 'KRAFT-BCO-002',
                'name' => 'Papel Kraft Blanco 200g',
                'description' => 'Papel kraft blanco de alta resistencia para empaques premium',
                'category_name' => 'Papeles Kraft',
                'material_type' => 'packaging',
                'unit_of_measure' => 'kg',
                'current_stock' => 1800.0000,
                'min_stock' => 800.0000,
                'max_stock' => 4000.0000,
                'safety_stock' => 250.0000,
                'avg_unit_cost' => 2.2000,
                'last_purchase_price' => 2.1500,
                'currency_id' => 1,
                'grammage' => 200.00,
                'width' => 120.00,
                'length' => null,
                'color' => 'blanco'
            ],

            // Insumos de Impresión
            [
                'sku' => 'INK-CYAN-001',
                'name' => 'Tinta Base Agua Cyan',
                'description' => 'Tinta flexográfica base agua color cyan para impresión de empaques',
                'category_name' => 'Insumos de Impresión',
                'material_type' => 'consumable',
                'unit_of_measure' => 'kg',
                'current_stock' => 150.0000,
                'min_stock' => 50.0000,
                'max_stock' => 300.0000,
                'safety_stock' => 20.0000,
                'avg_unit_cost' => 8.5000,
                'last_purchase_price' => 8.3500,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => 'cyan'
            ],
            [
                'sku' => 'VARNISH-MT-001',
                'name' => 'Barniz Mate UV',
                'description' => 'Barniz curable UV con acabado mate para protección de impresos',
                'category_name' => 'Insumos de Impresión',
                'material_type' => 'consumable',
                'unit_of_measure' => 'kg',
                'current_stock' => 200.0000,
                'min_stock' => 75.0000,
                'max_stock' => 400.0000,
                'safety_stock' => 30.0000,
                'avg_unit_cost' => 12.0000,
                'last_purchase_price' => 11.7500,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => null
            ],

            // Películas Plásticas
            [
                'sku' => 'FILM-PE-001',
                'name' => 'Película de Polietileno 50 micras',
                'description' => 'Película de polietileno de baja densidad para laminación',
                'category_name' => 'Películas Plásticas',
                'material_type' => 'packaging',
                'unit_of_measure' => 'kg',
                'current_stock' => 600.0000,
                'min_stock' => 200.0000,
                'max_stock' => 1200.0000,
                'safety_stock' => 100.0000,
                'avg_unit_cost' => 2.4000,
                'last_purchase_price' => 2.3500,
                'currency_id' => 1,
                'grammage' => null,
                'width' => 100.00,
                'length' => 500.00,
                'color' => 'transparente'
            ],

            // Químicos para Tratamiento de Agua
            [
                'sku' => 'CHEM-PAC-001',
                'name' => 'Policloruro de Aluminio (PAC)',
                'description' => 'Coagulante para tratamiento de aguas residuales',
                'category_name' => 'Químicos para Tratamiento de Agua',
                'material_type' => 'chemical',
                'unit_of_measure' => 'kg',
                'current_stock' => 2500.0000,
                'min_stock' => 1000.0000,
                'max_stock' => 5000.0000,
                'safety_stock' => 300.0000,
                'avg_unit_cost' => 0.8500,
                'last_purchase_price' => 0.8200,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => null
            ]
        ];

        foreach ($materiales as $material) {
            $category = $catMap[$material['category_name']] ?? null;

            if ($category) {
                unset($material['category_name']);
                $material['category_id'] = $category->id;

                $material['material_type_id'] = $typeMap[$material['material_type']] ?? null;
                $material['unit_of_measure_id'] = $uomMap[$material['unit_of_measure']] ?? null;

                unset($material['material_type'], $material['unit_of_measure']);

                Material::create($material);
            }
        }

        // Generar variaciones de materiales (misma categoría, diferentes especificaciones)
        $this->createMaterialVariations($catMap, $typeMap, $uomMap);
    }

    private function createMaterialVariations($catMap, $typeMap, $uomMap)
    {
        // Variaciones de gramajes para papeles kraft
        $gramajes = [80, 100, 120, 150, 180, 200, 250, 300];
        $baseSku = 100;

        if (isset($catMap['Papeles Kraft'])) {
            foreach ($gramajes as $index => $gramaje) {
                Material::create([
                    'sku' => 'KRAFT-G' . str_pad($gramaje, 3, '0', STR_PAD_LEFT),
                    'name' => "Papel Kraft Natural {$gramaje}g",
                    'description' => "Papel kraft natural de {$gramaje}g/m² para empaques",
                    'category_id' => $catMap['Papeles Kraft']->id,
                    'material_type_id' => $typeMap['packaging'] ?? null,
                    'unit_of_measure_id' => $uomMap['kg'] ?? null,
                    'current_stock' => rand(500, 2000),
                    'min_stock' => 300,
                    'max_stock' => 3000,
                    'safety_stock' => 100,
                    'avg_unit_cost' => round(1.50 + ($gramaje * 0.005), 2),
                    'last_purchase_price' => round(1.45 + ($gramaje * 0.005), 2),
                    'currency_id' => 1,
                    'grammage' => $gramaje,
                    'width' => 120.00,
                    'length' => null,
                    'color' => 'natural'
                ]);
            }
        }

        // Variaciones de cartón corrugado
        $flautas = ['A', 'B', 'C', 'E'];
        $tests = [150, 200, 250];

        if (isset($catMap['Cartón Corrugado'])) {
            foreach ($flautas as $flauta) {
                foreach ($tests as $test) {
                    Material::create([
                        'sku' => "CART-F{$flauta}-T{$test}",
                        'name' => "Cartón Corrugado Flauta {$flauta} Test {$test}",
                        'description' => "Cartón corrugado con flauta {$flauta} y test {$test}",
                        'category_id' => $catMap['Cartón Corrugado']->id,
                        'material_type_id' => $typeMap['packaging'] ?? null,
                        'unit_of_measure_id' => $uomMap['pliego'] ?? null,
                        'current_stock' => rand(1000, 5000),
                        'min_stock' => 500,
                        'max_stock' => 8000,
                        'safety_stock' => 200,
                        'avg_unit_cost' => round(1.80 + ($test * 0.005), 2),
                        'last_purchase_price' => round(1.75 + ($test * 0.005), 2),
                        'currency_id' => 1,
                        'grammage' => $test * 1.5,
                        'width' => 100.00,
                        'length' => 150.00,
                        'color' => 'kraft'
                    ]);
                }
            }
        }
    }
}
