<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaterialCategory;
use Illuminate\Support\Facades\DB;

class MaterialCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Categorías principales (nivel 1)
        $mainCategories = [
            [
                'name' => 'Materias Primas para Papel',
                'attributes' => json_encode([
                    'tipo_medida' => ['kg', 'tonelada'],
                    'control_humedad' => true,
                    'ficha_tecnica_requerida' => true
                ])
            ],
            [
                'name' => 'Insumos Químicos',
                'attributes' => json_encode([
                    'tipo_medida' => ['kg', 'litro', 'galon'],
                    'hoja_seguridad' => true,
                    'control_lote' => true,
                    'fecha_vencimiento' => true
                ])
            ],
            [
                'name' => 'Materiales para Empaques',
                'attributes' => json_encode([
                    'tipo_medida' => ['unidad', 'rollo', 'paquete'],
                    'dimensiones' => true,
                    'gramaje' => true
                ])
            ],
            [
                'name' => 'Insumos de Impresión',
                'attributes' => json_encode([
                    'tipo_medida' => ['litro', 'kg', 'unidad'],
                    'colores_disponibles' => true,
                    'base_solvente' => ['agua', 'aceite', 'uv']
                ])
            ],
            [
                'name' => 'Materiales para Maquila de Cajas',
                'attributes' => json_encode([
                    'tipo_medida' => ['unidad', 'pliego', 'rollo'],
                    'dimensiones_personalizables' => true,
                    'acabados' => ['brillante', 'mate', 'uv', 'laminado']
                ])
            ],
            [
                'name' => 'Refacciones y Mantenimiento',
                'attributes' => json_encode([
                    'tipo_medida' => ['pieza', 'kit', 'metro'],
                    'equipo_asociado' => true,
                    'vida_util' => true
                ])
            ]
        ];

        foreach ($mainCategories as $category) {
            $mainCat = MaterialCategory::create($category);

            // Crear subcategorías según la categoría principal
            $this->createSubCategories($mainCat);
        }
    }

    private function createSubCategories($parent)
    {
        $subCategories = [
            'Materias Primas para Papel' => [
                [
                    'name' => 'Pastas y Fibras',
                    'attributes' => json_encode([
                        'tipo_fibra' => ['virgen', 'reciclada'],
                        'origen' => ['nacional', 'importado'],
                        'blancura' => true
                    ])
                ],
                [
                    'name' => 'Papeles Reciclados',
                    'attributes' => json_encode([
                        'clasificacion' => ['OCC', 'blanco', 'peri?dico'],
                        'grado_contaminacion' => ['bajo', 'medio', 'alto']
                    ])
                ],
                [
                    'name' => 'Pulpas Químicas',
                    'attributes' => json_encode([
                        'proceso' => ['kraft', 'sulfito'],
                        'blanqueada' => [true, false]
                    ])
                ]
            ],
            'Insumos Químicos' => [
                [
                    'name' => 'Aditivos para Producción',
                    'attributes' => json_encode([
                        'funcion' => ['retencion', 'drenaje', 'resistencia'],
                        'presentacion' => ['liquido', 'polvo']
                    ])
                ],
                [
                    'name' => 'Químicos para Tratamiento de Agua',
                    'attributes' => json_encode([
                        'tipo' => ['coagulante', 'floculante', 'biocida'],
                        'concentracion' => true
                    ])
                ],
                [
                    'name' => 'Recubrimientos y Ligantes',
                    'attributes' => json_encode([
                        'base' => ['almidon', 'latex', 'proteina'],
                        'viscosidad' => true
                    ])
                ]
            ],
            'Materiales para Empaques' => [
                [
                    'name' => 'Cartón Corrugado',
                    'attributes' => json_encode([
                        'tipo' => ['sencillo', 'doble', 'triple'],
                        'flauta' => ['A', 'B', 'C', 'E', 'F'],
                        'test' => ['150', '200', '250', '300']
                    ])
                ],
                [
                    'name' => 'Papeles Kraft',
                    'attributes' => json_encode([
                        'color' => ['natural', 'blanco'],
                        'acabado' => ['natural', 'satinado']
                    ])
                ],
                [
                    'name' => 'Películas Plásticas',
                    'attributes' => json_encode([
                        'material' => ['polietileno', 'polipropileno', 'PET'],
                        'calibre' => ['micron', 'mil']
                    ])
                ]
            ]
        ];

        if (isset($subCategories[$parent->name])) {
            foreach ($subCategories[$parent->name] as $subCat) {
                MaterialCategory::create([
                    'name' => $subCat['name'],
                    'parent_id' => $parent->id,
                    'attributes' => $subCat['attributes']
                ]);
            }
        }
    }
}
