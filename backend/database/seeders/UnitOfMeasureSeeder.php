<?php
// database/seeders/UnitOfMeasureSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitOfMeasureSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            // Unidades de peso
            [
                'code' => 'kg',
                'name' => 'Kilogramo',
                'symbol' => 'kg',
                'category' => 'weight',
                'conversion_factor' => 1,
                'is_base_unit' => true,
                'decimal_places' => 3
            ],
            [
                'code' => 'g',
                'name' => 'Gramo',
                'symbol' => 'g',
                'category' => 'weight',
                'conversion_factor' => 0.001,
                'base_unit_id' => null, // Se actualizará después
                'is_base_unit' => false,
                'decimal_places' => 2
            ],
            [
                'code' => 'ton',
                'name' => 'Tonelada',
                'symbol' => 't',
                'category' => 'weight',
                'conversion_factor' => 1000,
                'base_unit_id' => null,
                'is_base_unit' => false,
                'decimal_places' => 3
            ],
            [
                'code' => 'lb',
                'name' => 'Libra',
                'symbol' => 'lb',
                'category' => 'weight',
                'conversion_factor' => 0.453592,
                'base_unit_id' => null,
                'is_base_unit' => false,
                'decimal_places' => 2
            ],

            // Unidades de volumen
            [
                'code' => 'l',
                'name' => 'Litro',
                'symbol' => 'L',
                'category' => 'volume',
                'conversion_factor' => 1,
                'is_base_unit' => true,
                'decimal_places' => 3
            ],
            [
                'code' => 'ml',
                'name' => 'Mililitro',
                'symbol' => 'mL',
                'category' => 'volume',
                'conversion_factor' => 0.001,
                'base_unit_id' => null,
                'is_base_unit' => false,
                'decimal_places' => 2
            ],
            [
                'code' => 'gal',
                'name' => 'Galón',
                'symbol' => 'gal',
                'category' => 'volume',
                'conversion_factor' => 3.78541,
                'base_unit_id' => null,
                'is_base_unit' => false,
                'decimal_places' => 3
            ],

            // Unidades de longitud
            [
                'code' => 'm',
                'name' => 'Metro',
                'symbol' => 'm',
                'category' => 'length',
                'conversion_factor' => 1,
                'is_base_unit' => true,
                'decimal_places' => 2
            ],
            [
                'code' => 'cm',
                'name' => 'Centímetro',
                'symbol' => 'cm',
                'category' => 'length',
                'conversion_factor' => 0.01,
                'base_unit_id' => null,
                'is_base_unit' => false,
                'decimal_places' => 2
            ],
            [
                'code' => 'mm',
                'name' => 'Milímetro',
                'symbol' => 'mm',
                'category' => 'length',
                'conversion_factor' => 0.001,
                'base_unit_id' => null,
                'is_base_unit' => false,
                'decimal_places' => 1
            ],

            // Unidades de área
            [
                'code' => 'm2',
                'name' => 'Metro cuadrado',
                'symbol' => 'm²',
                'category' => 'area',
                'conversion_factor' => 1,
                'is_base_unit' => true,
                'decimal_places' => 2
            ],
            [
                'code' => 'cm2',
                'name' => 'Centímetro cuadrado',
                'symbol' => 'cm²',
                'category' => 'area',
                'conversion_factor' => 0.0001,
                'base_unit_id' => null,
                'is_base_unit' => false,
                'decimal_places' => 2
            ],

            // Unidades de unidades
            [
                'code' => 'unidad',
                'name' => 'Unidad',
                'symbol' => 'ud',
                'category' => 'units',
                'conversion_factor' => 1,
                'is_base_unit' => true,
                'decimal_places' => 0
            ],
            [
                'code' => 'docena',
                'name' => 'Docena',
                'symbol' => 'doc',
                'category' => 'units',
                'conversion_factor' => 12,
                'base_unit_id' => null,
                'is_base_unit' => false,
                'decimal_places' => 2
            ],
            [
                'code' => 'ciento',
                'name' => 'Ciento',
                'symbol' => 'cien',
                'category' => 'units',
                'conversion_factor' => 100,
                'base_unit_id' => null,
                'is_base_unit' => false,
                'decimal_places' => 2
            ],
            [
                'code' => 'millar',
                'name' => 'Millar',
                'symbol' => 'mil',
                'category' => 'units',
                'conversion_factor' => 1000,
                'base_unit_id' => null,
                'is_base_unit' => false,
                'decimal_places' => 3
            ],

            // Unidades específicas de la industria papelera
            [
                'code' => 'rollo',
                'name' => 'Rollo',
                'symbol' => 'rollo',
                'category' => 'paper_units',
                'conversion_factor' => 1,
                'is_base_unit' => true,
                'decimal_places' => 2
            ],
            [
                'code' => 'pliego',
                'name' => 'Pliego',
                'symbol' => 'pl',
                'category' => 'paper_units',
                'conversion_factor' => 1,
                'is_base_unit' => true,
                'decimal_places' => 2
            ],
            [
                'code' => 'paquete',
                'name' => 'Paquete',
                'symbol' => 'pq',
                'category' => 'paper_units',
                'conversion_factor' => 1,
                'is_base_unit' => true,
                'decimal_places' => 2
            ],
            [
                'code' => 'caja',
                'name' => 'Caja',
                'symbol' => 'caja',
                'category' => 'paper_units',
                'conversion_factor' => 1,
                'is_base_unit' => true,
                'decimal_places' => 2
            ]
        ];

        // Insertar unidades
        foreach ($units as $unit) {
            DB::table('units_of_measure')->updateOrInsert(
                ['code' => $unit['code']],
                $unit
            );
        }

        // Actualizar las relaciones base_unit_id
        $kg = DB::table('units_of_measure')->where('code', 'kg')->first();
        $l = DB::table('units_of_measure')->where('code', 'l')->first();
        $m = DB::table('units_of_measure')->where('code', 'm')->first();
        $m2 = DB::table('units_of_measure')->where('code', 'm2')->first();
        $unidad = DB::table('units_of_measure')->where('code', 'unidad')->first();

        if ($kg) {
            DB::table('units_of_measure')
                ->whereIn('code', ['g', 'ton', 'lb'])
                ->update(['base_unit_id' => $kg->id]);
        }

        if ($l) {
            DB::table('units_of_measure')
                ->whereIn('code', ['ml', 'gal'])
                ->update(['base_unit_id' => $l->id]);
        }

        if ($m) {
            DB::table('units_of_measure')
                ->whereIn('code', ['cm', 'mm'])
                ->update(['base_unit_id' => $m->id]);
        }

        if ($m2) {
            DB::table('units_of_measure')
                ->where('code', 'cm2')
                ->update(['base_unit_id' => $m2->id]);
        }

        if ($unidad) {
            DB::table('units_of_measure')
                ->whereIn('code', ['docena', 'ciento', 'millar'])
                ->update(['base_unit_id' => $unidad->id]);
        }
    }
}
