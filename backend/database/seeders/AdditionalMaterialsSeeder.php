<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\MaterialType;
use App\Models\UnitOfMeasure;

class AdditionalMaterialsSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener mapeos
        $categorias = MaterialCategory::with('parent')->get();
        $catMap = [];
        foreach ($categorias as $cat) {
            $catMap[$cat->name] = $cat;
        }

        $typeMap = MaterialType::pluck('id', 'code');
        $uomMap = UnitOfMeasure::pluck('id', 'code');

        // Material de Oficina - Papelería Básica
        $materialesNuevos = [
            // Papelería Básica
            [
                'sku' => 'OFF-PAP-LTR-001',
                'name' => 'Papel Bond Carta 75g',
                'description' => 'Resma de papel bond tamaño carta 75g/m², 500 hojas',
                'category_name' => 'Papelería Básica',
                'material_type' => 'consumable',
                'unit_of_measure' => 'resma',
                'current_stock' => 150.0000,
                'min_stock' => 50.0000,
                'max_stock' => 300.0000,
                'safety_stock' => 20.0000,
                'avg_unit_cost' => 5.5000,
                'last_purchase_price' => 5.2500,
                'currency_id' => 1,
                'grammage' => 75.00,
                'width' => 21.59,
                'length' => 27.94,
                'color' => 'blanco'
            ],
            [
                'sku' => 'OFF-PAP-OF-002',
                'name' => 'Papel Bond Oficio 75g',
                'description' => 'Resma de papel bond tamaño oficio 75g/m², 500 hojas',
                'category_name' => 'Papelería Básica',
                'material_type' => 'consumable',
                'unit_of_measure' => 'resma',
                'current_stock' => 80.0000,
                'min_stock' => 30.0000,
                'max_stock' => 200.0000,
                'safety_stock' => 15.0000,
                'avg_unit_cost' => 7.5000,
                'last_purchase_price' => 7.2000,
                'currency_id' => 1,
                'grammage' => 75.00,
                'width' => 21.59,
                'length' => 33.02,
                'color' => 'blanco'
            ],
            [
                'sku' => 'OFF-PAP-A4-003',
                'name' => 'Papel Bond A4 80g',
                'description' => 'Caja con 5 resmas de papel A4 80g/m², alta calidad',
                'category_name' => 'Papelería Básica',
                'material_type' => 'consumable',
                'unit_of_measure' => 'caja',
                'current_stock' => 45.0000,
                'min_stock' => 10.0000,
                'max_stock' => 100.0000,
                'safety_stock' => 5.0000,
                'avg_unit_cost' => 32.0000,
                'last_purchase_price' => 31.0000,
                'currency_id' => 1,
                'grammage' => 80.00,
                'width' => 21.00,
                'length' => 29.70,
                'color' => 'blanco'
            ],
            [
                'sku' => 'OFF-NOTE-001',
                'name' => 'Block de Notas Adhesivas 3x3',
                'description' => 'Block de notas Post-it 3x3 pulgadas, 100 hojas',
                'category_name' => 'Papelería Básica',
                'material_type' => 'consumable',
                'unit_of_measure' => 'paquete',
                'current_stock' => 200.0000,
                'min_stock' => 50.0000,
                'max_stock' => 500.0000,
                'safety_stock' => 25.0000,
                'avg_unit_cost' => 2.5000,
                'last_purchase_price' => 2.3000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => 7.62,
                'length' => 7.62,
                'color' => 'variado'
            ],

            // Artículos de Escritura
            [
                'sku' => 'OFF-PEN-BIC-001',
                'name' => 'Pluma Bic Negro',
                'description' => 'Pluma de tinta negra, punta media, caja con 12 piezas',
                'category_name' => 'Artículos de Escritura',
                'material_type' => 'consumable',
                'unit_of_measure' => 'caja',
                'current_stock' => 60.0000,
                'min_stock' => 20.0000,
                'max_stock' => 150.0000,
                'safety_stock' => 10.0000,
                'avg_unit_cost' => 4.8000,
                'last_purchase_price' => 4.5000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => 'negro'
            ],
            [
                'sku' => 'OFF-HLT-YEL-001',
                'name' => 'Resaltador Amarillo',
                'description' => 'Resaltador fluorescente amarillo, punta biselada',
                'category_name' => 'Artículos de Escritura',
                'material_type' => 'consumable',
                'unit_of_measure' => 'pieza',
                'current_stock' => 120.0000,
                'min_stock' => 30.0000,
                'max_stock' => 300.0000,
                'safety_stock' => 15.0000,
                'avg_unit_cost' => 1.2000,
                'last_purchase_price' => 1.1000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => 'amarillo'
            ],

            // Artículos de Archivo
            [
                'sku' => 'OFF-FLD-LTR-001',
                'name' => 'Folder Cartulina Tamaño Carta',
                'description' => 'Folder de cartulina manila tamaño carta, paquete con 50 piezas',
                'category_name' => 'Artículos de Archivo',
                'material_type' => 'consumable',
                'unit_of_measure' => 'paquete',
                'current_stock' => 40.0000,
                'min_stock' => 10.0000,
                'max_stock' => 100.0000,
                'safety_stock' => 5.0000,
                'avg_unit_cost' => 12.5000,
                'last_purchase_price' => 12.0000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => 'manila'
            ],

            // Consumibles de Impresión
            [
                'sku' => 'IT-TNR-101-001',
                'name' => 'Tóner HP 101A Negro',
                'description' => 'Tóner original HP 101A para impresoras LaserJet, rendimiento 1400 páginas',
                'category_name' => 'Consumibles de Impresión',
                'material_type' => 'consumable',
                'unit_of_measure' => 'pieza',
                'current_stock' => 25.0000,
                'min_stock' => 8.0000,
                'max_stock' => 50.0000,
                'safety_stock' => 5.0000,
                'avg_unit_cost' => 55.0000,
                'last_purchase_price' => 52.5000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => 'negro'
            ],
            [
                'sku' => 'IT-TNR-101-002',
                'name' => 'Tóner HP 101A Cian',
                'description' => 'Tóner original HP 101A color cian para impresoras LaserJet color',
                'category_name' => 'Consumibles de Impresión',
                'material_type' => 'consumable',
                'unit_of_measure' => 'pieza',
                'current_stock' => 12.0000,
                'min_stock' => 5.0000,
                'max_stock' => 30.0000,
                'safety_stock' => 3.0000,
                'avg_unit_cost' => 65.0000,
                'last_purchase_price' => 63.0000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => 'cian'
            ],

            // Accesorios de Cómputo
            [
                'sku' => 'IT-MSE-LOG-001',
                'name' => 'Mouse Óptico USB Logitech',
                'description' => 'Mouse óptico con cable USB, 3 botones, resolución 1000 dpi',
                'category_name' => 'Accesorios de Cómputo',
                'material_type' => 'consumable',
                'unit_of_measure' => 'pieza',
                'current_stock' => 50.0000,
                'min_stock' => 15.0000,
                'max_stock' => 100.0000,
                'safety_stock' => 10.0000,
                'avg_unit_cost' => 8.5000,
                'last_purchase_price' => 8.0000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => 'negro'
            ],
            [
                'sku' => 'IT-KBD-DELL-001',
                'name' => 'Teclado USB Dell',
                'description' => 'Teclado de tamaño completo con cable USB, teclas silenciosas',
                'category_name' => 'Accesorios de Cómputo',
                'material_type' => 'consumable',
                'unit_of_measure' => 'pieza',
                'current_stock' => 30.0000,
                'min_stock' => 10.0000,
                'max_stock' => 60.0000,
                'safety_stock' => 5.0000,
                'avg_unit_cost' => 15.0000,
                'last_purchase_price' => 14.5000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => 45.00,
                'length' => 15.00,
                'color' => 'negro'
            ],

            // Almacenamiento y Respaldo
            [
                'sku' => 'IT-USB-32G-001',
                'name' => 'USB 3.0 32GB Kingston',
                'description' => 'Memoria USB 3.0, 32GB de capacidad, velocidad de lectura 100MB/s',
                'category_name' => 'Almacenamiento y Respaldo',
                'material_type' => 'consumable',
                'unit_of_measure' => 'pieza',
                'current_stock' => 100.0000,
                'min_stock' => 30.0000,
                'max_stock' => 200.0000,
                'safety_stock' => 20.0000,
                'avg_unit_cost' => 12.0000,
                'last_purchase_price' => 11.5000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => 'negro'
            ],

            // Productos Químicos de Limpieza
            [
                'sku' => 'CLN-DES-CLO-001',
                'name' => 'Cloro Líquido 1L',
                'description' => 'Cloro desinfectante concentrado, presentación 1 litro',
                'category_name' => 'Productos Químicos de Limpieza',
                'material_type' => 'chemical',
                'unit_of_measure' => 'litro',
                'current_stock' => 80.0000,
                'min_stock' => 20.0000,
                'max_stock' => 200.0000,
                'safety_stock' => 15.0000,
                'avg_unit_cost' => 1.5000,
                'last_purchase_price' => 1.4000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => null
            ],
            [
                'sku' => 'CLN-DET-001',
                'name' => 'Detergente Líquido Multiusos 5L',
                'description' => 'Detergente líquido biodegradable para limpieza general, 5 litros',
                'category_name' => 'Productos Químicos de Limpieza',
                'material_type' => 'chemical',
                'unit_of_measure' => 'galon',
                'current_stock' => 40.0000,
                'min_stock' => 10.0000,
                'max_stock' => 100.0000,
                'safety_stock' => 8.0000,
                'avg_unit_cost' => 8.5000,
                'last_purchase_price' => 8.2000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => null
            ],

            // Utensilios de Limpieza
            [
                'sku' => 'CLN-MOP-001',
                'name' => 'Trapeador de Microfibra',
                'description' => 'Trapeador profesional con mango telescópico y refill de microfibra',
                'category_name' => 'Utensilios de Limpieza',
                'material_type' => 'consumable',
                'unit_of_measure' => 'pieza',
                'current_stock' => 25.0000,
                'min_stock' => 8.0000,
                'max_stock' => 50.0000,
                'safety_stock' => 5.0000,
                'avg_unit_cost' => 12.0000,
                'last_purchase_price' => 11.5000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => 120.00,
                'color' => 'azul'
            ],

            // Equipo de Protección Personal
            [
                'sku' => 'CLN-GLV-NIT-001',
                'name' => 'Guantes de Nitrilo Desechables',
                'description' => 'Guantes de nitrilo talla M, sin polvo, caja con 100 pares',
                'category_name' => 'Equipo de Protección Personal',
                'material_type' => 'consumable',
                'unit_of_measure' => 'caja',
                'current_stock' => 30.0000,
                'min_stock' => 10.0000,
                'max_stock' => 80.0000,
                'safety_stock' => 5.0000,
                'avg_unit_cost' => 18.0000,
                'last_purchase_price' => 17.5000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => 'azul'
            ],

            // Cables y Alambres
            [
                'sku' => 'ELE-CBL-HDM-001',
                'name' => 'Cable HDMI 2m',
                'description' => 'Cable HDMI versión 2.0, 2 metros, soporta 4K',
                'category_name' => 'Cables y Alambres',
                'material_type' => 'consumable',
                'unit_of_measure' => 'pieza',
                'current_stock' => 60.0000,
                'min_stock' => 20.0000,
                'max_stock' => 150.0000,
                'safety_stock' => 10.0000,
                'avg_unit_cost' => 5.5000,
                'last_purchase_price' => 5.0000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => 200.00,
                'color' => 'negro'
            ],
            [
                'sku' => 'ELE-CBL-USB-001',
                'name' => 'Cable USB C a USB C 1m',
                'description' => 'Cable USB tipo C a tipo C, carga rápida, 1 metro',
                'category_name' => 'Cables y Alambres',
                'material_type' => 'consumable',
                'unit_of_measure' => 'pieza',
                'current_stock' => 45.0000,
                'min_stock' => 15.0000,
                'max_stock' => 100.0000,
                'safety_stock' => 8.0000,
                'avg_unit_cost' => 4.0000,
                'last_purchase_price' => 3.8000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => 100.00,
                'color' => 'blanco'
            ],

            // Iluminación
            [
                'sku' => 'ELE-LED-A60-001',
                'name' => 'Foco LED 9W Luz Fría',
                'description' => 'Foco LED 9W equivalente a 60W, base E27, luz fría 6500K',
                'category_name' => 'Iluminación',
                'material_type' => 'consumable',
                'unit_of_measure' => 'pieza',
                'current_stock' => 150.0000,
                'min_stock' => 50.0000,
                'max_stock' => 300.0000,
                'safety_stock' => 25.0000,
                'avg_unit_cost' => 2.5000,
                'last_purchase_price' => 2.3000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => 6.00,
                'length' => 11.00,
                'color' => 'blanco'
            ],

            // Refacciones para Montacargas
            [
                'sku' => 'TRP-FLT-MT-001',
                'name' => 'Filtro de Aceite Montacarga Toyota',
                'description' => 'Filtro de aceite original para montacarga Toyota 7FBEU15',
                'category_name' => 'Refacciones para Montacargas',
                'material_type' => 'spare_part',
                'unit_of_measure' => 'pieza',
                'current_stock' => 12.0000,
                'min_stock' => 4.0000,
                'max_stock' => 25.0000,
                'safety_stock' => 3.0000,
                'avg_unit_cost' => 15.0000,
                'last_purchase_price' => 14.5000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => null
            ],

            // Llantas y Neumáticos
            [
                'sku' => 'TRP-TIR-155-001',
                'name' => 'Llanta 155/80R13 para Montacarga',
                'description' => 'Llanta maciza para montacarga, medida 155/80R13, color negro',
                'category_name' => 'Llantas y Neumáticos',
                'material_type' => 'spare_part',
                'unit_of_measure' => 'pieza',
                'current_stock' => 8.0000,
                'min_stock' => 2.0000,
                'max_stock' => 20.0000,
                'safety_stock' => 2.0000,
                'avg_unit_cost' => 85.0000,
                'last_purchase_price' => 82.5000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => 15.50,
                'length' => null,
                'color' => 'negro'
            ],

            // Licencias de Sistema Operativo
            [
                'sku' => 'LIC-WIN-PRO-001',
                'name' => 'Licencia Windows 11 Pro',
                'description' => 'Licencia original Windows 11 Professional, 1 equipo',
                'category_name' => 'Licencias de Sistema Operativo',
                'material_type' => 'consumable',
                'unit_of_measure' => 'unidad',
                'current_stock' => 15.0000,
                'min_stock' => 5.0000,
                'max_stock' => 50.0000,
                'safety_stock' => 3.0000,
                'avg_unit_cost' => 145.0000,
                'last_purchase_price' => 140.0000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => null
            ],

            // Licencias de Productividad
            [
                'sku' => 'LIC-OFF-HS-001',
                'name' => 'Microsoft 365 Business Standard',
                'description' => 'Suscripción anual Microsoft 365 Business Standard, 1 usuario',
                'category_name' => 'Licencias de Productividad',
                'material_type' => 'consumable',
                'unit_of_measure' => 'suscripcion',
                'current_stock' => 25.0000,
                'min_stock' => 10.0000,
                'max_stock' => 100.0000,
                'safety_stock' => 5.0000,
                'avg_unit_cost' => 150.0000,
                'last_purchase_price' => 145.0000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => null
            ],

            // Licencias de Seguridad
            [
                'sku' => 'LIC-AVA-BS-001',
                'name' => 'Antivirus Avast Business Antivirus',
                'description' => 'Licencia anual Avast Business Antivirus para 10 equipos',
                'category_name' => 'Licencias de Seguridad',
                'material_type' => 'consumable',
                'unit_of_measure' => 'unidad',
                'current_stock' => 8.0000,
                'min_stock' => 2.0000,
                'max_stock' => 20.0000,
                'safety_stock' => 2.0000,
                'avg_unit_cost' => 120.0000,
                'last_purchase_price' => 115.0000,
                'currency_id' => 1,
                'grammage' => null,
                'width' => null,
                'length' => null,
                'color' => null
            ]
        ];

        // Insertar los nuevos materiales
        foreach ($materialesNuevos as $material) {
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
    }
}
