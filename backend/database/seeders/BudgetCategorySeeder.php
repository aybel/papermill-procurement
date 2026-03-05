<?php

namespace Database\Seeders;

use App\Models\BudgetCategory;
use Illuminate\Database\Seeder;

class BudgetCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'id' => 1,
                'name' => 'Gasto de operación',
                'description' => 'Gasto para la operación diaria del departamento',
                'is_active' => 1,
                'created_at' => '2026-03-04 19:34:48',
                'updated_at' => '2026-03-04 19:34:48',
            ],
            [
                'id' => 2,
                'name' => 'Gasto de produccion',
                'description' => 'Gasto para materiales de producción',
                'is_active' => 1,
                'created_at' => '2026-03-04 19:35:14',
                'updated_at' => '2026-03-04 19:35:14',
            ],
            [
                'id' => 3,
                'name' => 'Gasto de mantenimiento',
                'description' => 'Recursos para mentenimiento de maquinaria de producción',
                'is_active' => 1,
                'created_at' => '2026-03-04 19:35:43',
                'updated_at' => '2026-03-04 19:35:43',
            ],
        ];

        foreach ($categories as $category) {
            BudgetCategory::updateOrCreate(
                ['id' => $category['id']],
                $category
            );
        }

        $this->command->info('✓ Categorías de presupuesto creadas correctamente');
    }
}
