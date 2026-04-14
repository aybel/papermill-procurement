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
            ],
            // NUEVAS CATEGORÍAS
            [
                'name' => 'Material de Oficina',
                'attributes' => json_encode([
                    'tipo_medida' => ['pieza', 'caja', 'paquete', 'resma'],
                    'categoria_papeleria' => ['papel', 'escritura', 'archivo', 'etiquetado'],
                    'requiere_control' => false
                ])
            ],
            [
                'name' => 'Materiales y Útiles Informáticos',
                'attributes' => json_encode([
                    'tipo_medida' => ['pieza', 'kit', 'caja'],
                    'tipo' => ['consumible', 'accesorio', 'limpieza'],
                    'compatible_con' => true
                ])
            ],
            [
                'name' => 'Material y Enseres de Limpieza',
                'attributes' => json_encode([
                    'tipo_medida' => ['litro', 'galon', 'pieza', 'paquete'],
                    'clasificacion' => ['quimico', 'utensilio', 'equipo_proteccion'],
                    'hoja_seguridad' => true
                ])
            ],
            [
                'name' => 'Material Eléctrico y Electrónico',
                'attributes' => json_encode([
                    'tipo_medida' => ['pieza', 'metro', 'caja', 'kit'],
                    'voltaje_nominal' => true,
                    'certificacion' => ['NOM', 'UL', 'CE']
                ])
            ],
            [
                'name' => 'Refacciones y Accesorios para Transporte',
                'attributes' => json_encode([
                    'tipo_medida' => ['pieza', 'juego', 'litro'],
                    'tipo_vehiculo' => ['montacarga', 'camioneta', 'camion', 'automovil'],
                    'criticidad' => ['alta', 'media', 'baja']
                ])
            ],
            [
                'name' => 'Licencias de Software',
                'attributes' => json_encode([
                    'tipo_medida' => ['unidad', 'suscripcion'],
                    'tipo_licencia' => ['perpetua', 'anual', 'mensual', 'volumen'],
                    'modelo' => ['on_premise', 'cloud', 'híbrido']
                ])
            ]
        ];

        foreach ($mainCategories as $category) {
            $mainCat = MaterialCategory::create($category);
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
            ],
            'Material de Oficina' => [
                [
                    'name' => 'Papelería Básica',
                    'attributes' => json_encode([
                        'tipo' => ['papel', 'cuadernos', 'bloques'],
                        'tamaño' => ['carta', 'oficio', 'A4', 'A3']
                    ])
                ],
                [
                    'name' => 'Artículos de Escritura',
                    'attributes' => json_encode([
                        'tipo' => ['lapiz', 'pluma', 'marcador', 'resaltador'],
                        'color_disponible' => true
                    ])
                ],
                [
                    'name' => 'Artículos de Archivo',
                    'attributes' => json_encode([
                        'tipo' => ['carpeta', 'folder', 'separador', 'enganche'],
                        'material' => ['cartulina', 'plastico', 'metal']
                    ])
                ],
                [
                    'name' => 'Etiquetas y Adhesivos',
                    'attributes' => json_encode([
                        'tipo' => ['etiqueta', 'cinta', 'pegamento'],
                        'formato' => ['rollo', 'hoja', 'individual']
                    ])
                ]
            ],
            'Materiales y Útiles Informáticos' => [
                [
                    'name' => 'Consumibles de Impresión',
                    'attributes' => json_encode([
                        'tipo' => ['toner', 'cartucho', 'cinta'],
                        'marca_compatible' => true,
                        'modelo_impresora' => true
                    ])
                ],
                [
                    'name' => 'Accesorios de Cómputo',
                    'attributes' => json_encode([
                        'tipo' => ['mouse', 'teclado', 'audifonos', 'camara'],
                        'conexion' => ['usb', 'bluetooth', 'inalambrico']
                    ])
                ],
                [
                    'name' => 'Almacenamiento y Respaldo',
                    'attributes' => json_encode([
                        'tipo' => ['usb', 'disco_externo', 'tarjeta_memoria', 'cd_dvd'],
                        'capacidad' => true
                    ])
                ],
                [
                    'name' => 'Cables y Adaptadores',
                    'attributes' => json_encode([
                        'tipo' => ['hdmi', 'usb', 'vga', 'ethernet', 'adaptador'],
                        'longitud' => true
                    ])
                ],
                [
                    'name' => 'Limpieza para Equipos',
                    'attributes' => json_encode([
                        'tipo' => ['aire_comprimido', 'limpiador_pantalla', 'paño'],
                        'presentacion' => ['aerosol', 'liquido', 'kit']
                    ])
                ]
            ],
            'Material y Enseres de Limpieza' => [
                [
                    'name' => 'Productos Químicos de Limpieza',
                    'attributes' => json_encode([
                        'tipo' => ['desinfectante', 'detergente', 'desengrasante', 'limpiavidrios'],
                        'concentracion' => ['concentrado', 'listo_usar']
                    ])
                ],
                [
                    'name' => 'Utensilios de Limpieza',
                    'attributes' => json_encode([
                        'tipo' => ['trapeador', 'escoba', 'recogedor', 'cubeta'],
                        'material' => ['plastico', 'metal', 'microfibra']
                    ])
                ],
                [
                    'name' => 'Papel y Absorbentes',
                    'attributes' => json_encode([
                        'tipo' => ['papel_higienico', 'toalla_papel', 'servilletas', 'absorbente'],
                        'presentacion' => ['rollo', 'paquete', 'caja']
                    ])
                ],
                [
                    'name' => 'Equipo de Protección Personal',
                    'attributes' => json_encode([
                        'tipo' => ['guantes', 'mascarilla', 'lentes', 'mandil', 'gorro'],
                        'talla' => ['ch', 'm', 'g', 'xg', 'unica']
                    ])
                ],
                [
                    'name' => 'Bolsas y Contenedores',
                    'attributes' => json_encode([
                        'tipo' => ['basura', 'reciclaje', 'organico'],
                        'capacidad' => ['pequeña', 'mediana', 'grande', 'industrial'],
                        'material' => ['plastico', 'biodegradable']
                    ])
                ]
            ],
            'Material Eléctrico y Electrónico' => [
                [
                    'name' => 'Cables y Alambres',
                    'attributes' => json_encode([
                        'tipo' => ['electrico', 'coaxial', 'par_trenzado', 'fibra_optica'],
                        'calibre' => true,
                        'voltaje' => true
                    ])
                ],
                [
                    'name' => 'Interruptores y Contactos',
                    'attributes' => json_encode([
                        'tipo' => ['sencillo', 'doble', 'apagador', 'contacto'],
                        'amperaje' => [10, 15, 20, 30],
                        'tipo_instalacion' => ['empotrar', 'sobreponer']
                    ])
                ],
                [
                    'name' => 'Iluminación',
                    'attributes' => json_encode([
                        'tipo' => ['led', 'fluorescente', 'incandescente', 'ahorrador'],
                        'base' => ['e27', 'e14', 'gu10', 't8', 't5'],
                        'potencia' => true
                    ])
                ],
                [
                    'name' => 'Componentes Electrónicos',
                    'attributes' => json_encode([
                        'tipo' => ['resistencia', 'capacitor', 'transistor', 'diodo', 'circuito'],
                        'valor' => true,
                        'tolerancia' => true
                    ])
                ],
                [
                    'name' => 'Herramientas Eléctricas',
                    'attributes' => json_encode([
                        'tipo' => ['taladro', 'esmeril', 'sierra', 'multimetro'],
                        'voltaje' => ['110v', '220v', 'bateria'],
                        'potencia' => true
                    ])
                ]
            ],
            'Refacciones y Accesorios para Transporte' => [
                [
                    'name' => 'Refacciones para Montacargas',
                    'attributes' => json_encode([
                        'tipo' => ['filtro', 'bateria', 'llanta', 'freno', 'motor'],
                        'modelo' => true,
                        'capacidad' => true
                    ])
                ],
                [
                    'name' => 'Refacciones para Camiones',
                    'attributes' => json_encode([
                        'tipo' => ['filtro_aceite', 'filtro_aire', 'balata', 'liquido_frenos'],
                        'marca_vehiculo' => true,
                        'modelo_vehiculo' => true
                    ])
                ],
                [
                    'name' => 'Llantas y Neumáticos',
                    'attributes' => json_encode([
                        'tipo_vehiculo' => ['montacarga', 'camioneta', 'camion', 'automovil'],
                        'medida' => true,
                        'tipo_llanta' => ['radial', 'diagonal', 'maciza']
                    ])
                ],
                [
                    'name' => 'Accesorios para Vehículos',
                    'attributes' => json_encode([
                        'tipo' => ['extintor', 'triangulos', 'botiquin', 'cargador', 'aditamento'],
                        'certificacion' => ['NOM', 'ISO', 'otra']
                    ])
                ],
                [
                    'name' => 'Lubricantes y Fluidos',
                    'attributes' => json_encode([
                        'tipo' => ['aceite_motor', 'aceite_hidraulico', 'grasa', 'refrigerante'],
                        'viscosidad' => true,
                        'presentacion' => ['litro', 'galon', 'barril']
                    ])
                ]
            ],
            'Licencias de Software' => [
                [
                    'name' => 'Licencias de Sistema Operativo',
                    'attributes' => json_encode([
                        'so' => ['windows', 'linux', 'macos'],
                        'edicion' => ['home', 'pro', 'enterprise', 'server'],
                        'cantidad_equipos' => true
                    ])
                ],
                [
                    'name' => 'Licencias de Productividad',
                    'attributes' => json_encode([
                        'suite' => ['office', 'google_workspace', 'libreoffice'],
                        'aplicaciones' => true,
                        'usuario_individual' => true
                    ])
                ],
                [
                    'name' => 'Licencias de Diseño',
                    'attributes' => json_encode([
                        'software' => ['adobe', 'autocad', 'corel', 'sketchup'],
                        'version' => true,
                        'tipo_usuario' => ['individual', 'team', 'enterprise']
                    ])
                ],
                [
                    'name' => 'Licencias de Seguridad',
                    'attributes' => json_encode([
                        'software' => ['antivirus', 'firewall', 'vpn', 'endpoint'],
                        'equipos_cubiertos' => true,
                        'vigencia' => true
                    ])
                ],
                [
                    'name' => 'Licencias Especializadas',
                    'attributes' => json_encode([
                        'software' => ['erp', 'crm', 'bpm', 'bi', 'cad'],
                        'modulos' => true,
                        'concurrentes' => true
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
