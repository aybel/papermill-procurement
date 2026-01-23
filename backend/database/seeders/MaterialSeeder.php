<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('es_MX');
        // Obtener IDs de tipos de material
        $typeIds = range(1, 10);
        $nombres = [
            'Celulosa Bleach', 'Celulosa Kraft', 'Pulpa Reciclada', 'Hipoclorito de Sodio', 'Peróxido de Hidrógeno',
            'Ácido Sulfúrico', 'Rollo de Papel Kraft', 'Caja de Cartón Corrugado', 'Film Stretch', 'Cinta Adhesiva',
            'Guantes de Nitrilo', 'Mascarilla N95', 'Rodamiento SKF', 'Banda Transportadora', 'Tinta Negra',
            'Pigmento Azul', 'Aditivo Retardante', 'Aditivo Hidrofóbico', 'Llave Stilson', 'Destornillador Plano',
            'Aceite Hidráulico', 'Grasa Multiusos', 'Casco de Seguridad', 'Lentes de Protección', 'Celulosa Fluff',
            'Celulosa Disolvente', 'Cloruro de Sodio', 'Poliacrilamida', 'Bolsa Plástica', 'Fleje Metálico',
            'Cutter Industrial', 'Escoba de Nylon', 'Filtro de Aire', 'Motor Eléctrico', 'Tinta Magenta',
            'Pigmento Verde', 'Aditivo Catiónico', 'Aditivo Aniónico', 'Martillo', 'Pinzas de Corte',
            'Aceite de Motor', 'Grasa de Litio', 'Chaleco Reflectante', 'Tapones Auditivos', 'Celulosa Microfibrilada',
            'Celulosa Especial', 'Ácido Clorhídrico', 'Policloruro de Aluminio', 'Caja Plegadiza', 'Espuma Protectora',
            'Guantes de Látex', 'Mascarilla Quirúrgica', 'Rodamiento NSK', 'Banda Dentada', 'Tinta Amarilla',
            'Pigmento Rojo', 'Aditivo Antiespumante', 'Aditivo Dispersante', 'Llave Inglesa', 'Cinta Métrica',
            'Aceite Sintético', 'Grasa Grafitada', 'Botas Dieléctricas', 'Arnés de Seguridad', 'Celulosa Termomecánica',
            'Celulosa Química', 'Ácido Oxálico', 'Polietileno', 'Caja de Microcorrugado', 'Film Termoencogible',
            'Escoba Industrial', 'Filtro de Agua', 'Motor de Corriente Continua', 'Tinta Cian', 'Pigmento Amarillo',
            'Aditivo Blanqueador', 'Aditivo Enzimático', 'Llave Allen', 'Cutter Retráctil', 'Aceite Mineral',
            'Grasa Marina', 'Gafas UV', 'Protector Facial'
        ];
        $descs = [
            'Celulosa blanqueada para papel de alta calidad.',
            'Celulosa kraft para cartón y papeles resistentes.',
            'Pulpa reciclada para productos ecológicos.',
            'Desinfectante y blanqueador industrial.',
            'Agente oxidante para procesos de blanqueo.',
            'Reactivo químico para ajuste de pH.',
            'Rollo de papel para embalaje industrial.',
            'Caja resistente para transporte de mercancía.',
            'Película plástica para envolver palets.',
            'Cinta para sellado de cajas.',
            'Guantes para protección química.',
            'Mascarilla para partículas finas.',
            'Rodamiento para maquinaria pesada.',
            'Banda para sistemas de transporte.',
            'Tinta para impresión offset.',
            'Pigmento para coloración de papel.',
            'Aditivo para retardar el secado.',
            'Aditivo para repeler agua.',
            'Herramienta para plomería industrial.',
            'Herramienta para mantenimiento general.',
            'Lubricante para sistemas hidráulicos.',
            'Grasa para rodamientos y engranajes.',
            'Protección para cabeza en planta.',
            'Lentes para protección ocular.',
            'Celulosa para productos absorbentes.',
            'Celulosa para procesos químicos.',
            'Sal para procesos industriales.',
            'Polímero para retención de agua.',
            'Bolsa para empaque de productos.',
            'Fleje para asegurar cargas.',
            'Cuchilla para corte de materiales.',
            'Escoba para limpieza industrial.',
            'Filtro para sistemas de aire.',
            'Motor para maquinaria.',
            'Tinta para impresión digital.',
            'Pigmento para tonos verdes.',
            'Aditivo para carga catiónica.',
            'Aditivo para carga aniónica.',
            'Herramienta para golpeo.',
            'Herramienta para corte de cables.',
            'Aceite para motores industriales.',
            'Grasa para altas temperaturas.',
            'Chaleco para visibilidad.',
            'Tapones para protección auditiva.',
            'Celulosa para refuerzo de papel.',
            'Celulosa para aplicaciones especiales.',
            'Reactivo para limpieza industrial.',
            'Coagulante para tratamiento de agua.',
            'Caja para productos delicados.',
            'Espuma para protección de equipos.',
            'Guantes para uso médico.',
            'Mascarilla para uso quirúrgico.',
            'Rodamiento para alta velocidad.',
            'Banda para transmisión de potencia.',
            'Tinta para impresión amarilla.',
            'Pigmento para tonos rojos.',
            'Aditivo para evitar espuma.',
            'Aditivo para dispersión de fibras.',
            'Herramienta para ajuste de tuercas.',
            'Herramienta para medición.',
            'Aceite para maquinaria de precisión.',
            'Grasa para ambientes extremos.',
            'Botas para protección eléctrica.',
            'Arnés para trabajos en altura.',
            'Celulosa para procesos termomecánicos.',
            'Celulosa para procesos químicos.',
            'Reactivo para limpieza de equipos.',
            'Polímero para embalaje.',
            'Caja para productos pequeños.',
            'Película para embalaje retráctil.',
            'Escoba para áreas grandes.',
            'Filtro para sistemas de agua.',
            'Motor para control de velocidad.',
            'Tinta para impresión azul.',
            'Pigmento para tonos amarillos.',
            'Aditivo para blanqueo óptico.',
            'Aditivo para procesos enzimáticos.',
            'Herramienta para tornillos hexagonales.',
            'Cuchilla retráctil para seguridad.',
            'Aceite para sistemas hidráulicos.',
            'Grasa para ambientes marinos.',
            'Lentes para protección UV.',
            'Protector facial para trabajos de riesgo.'
        ];
        $materiales = [];
        for ($i = 1; $i <= 80; $i++) {
            $cat = (($i - 1) % 10) + 1;
            $type = $typeIds[($i - 1) % count($typeIds)];
            $idx = ($i - 1) % count($nombres);
            $materiales[] = [
                'sku' => 'MAT-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'name' => $nombres[$idx],
                'description' => $descs[$idx],
                'category_id' => $cat,
                'material_type_id' => $type,
                'unit_of_measure' => $faker->randomElement(['kg','ton','rollo','litro','pieza','caja','bulto','metro','galón','par']),
                'current_stock' => $faker->numberBetween(0, 10000),
                'min_stock' => $faker->numberBetween(0, 1000),
                'max_stock' => $faker->numberBetween(1000, 20000),
                'safety_stock' => $faker->numberBetween(0, 500),
                'avg_unit_cost' => $faker->randomFloat(2, 10, 1000),
                'last_purchase_price' => $faker->randomFloat(2, 10, 1200),
                'currency_id' => 1,
                'grammage' => $faker->optional()->numberBetween(60, 200),
                'width' => $faker->optional()->numberBetween(50, 200),
                'length' => $faker->optional()->numberBetween(100, 2000),
                'color' => $faker->optional()->safeColorName(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('materials')->insert($materiales);
    }
}
