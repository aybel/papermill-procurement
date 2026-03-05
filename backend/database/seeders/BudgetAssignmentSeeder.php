<?php

namespace Database\Seeders;

use App\Models\BudgetAssignment;
use App\Models\User;
use Illuminate\Database\Seeder;

class BudgetAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el ID del Super Admin
        $adminUser = User::where('email', 'admin@example.com')->first();
        $adminId = $adminUser?->id ?? User::first()?->id ?? 1;

        $assignments = [
            [
                'department_id' => 3,
                'budget_category_id' => 1,
                'year' => 2026,
                'assigned_amount' => 2650000.0000,
                'justification' => 'Recursos para GO',
                'created_by' => $adminId,
                'approved_by' => null,
                'created_at' => '2026-03-04 19:38:33',
                'updated_at' => '2026-03-04 19:38:33',
            ],
            [
                'department_id' => 5,
                'budget_category_id' => 1,
                'year' => 2026,
                'assigned_amount' => 125000.0000,
                'justification' => 'Recursos para papeleria y mobilario',
                'created_by' => $adminId,
                'approved_by' => null,
                'created_at' => '2026-03-04 19:39:04',
                'updated_at' => '2026-03-04 19:39:04',
            ],
            [
                'department_id' => 4,
                'budget_category_id' => 1,
                'year' => 2026,
                'assigned_amount' => 85000.0000,
                'justification' => 'Recursos para papeleria y computo',
                'created_by' => $adminId,
                'approved_by' => null,
                'created_at' => '2026-03-04 19:39:31',
                'updated_at' => '2026-03-04 19:39:31',
            ],
            [
                'department_id' => 7,
                'budget_category_id' => 1,
                'year' => 2026,
                'assigned_amount' => 450000.0000,
                'justification' => 'Recursos para materiales de mantenimiento de la maquinaria',
                'created_by' => $adminId,
                'approved_by' => null,
                'created_at' => '2026-03-04 19:40:19',
                'updated_at' => '2026-03-04 19:41:24',
            ],
            [
                'department_id' => 2,
                'budget_category_id' => 1,
                'year' => 2026,
                'assigned_amount' => 65000.0000,
                'justification' => 'Recursos para papeleria y herramientas',
                'created_by' => $adminId,
                'approved_by' => null,
                'created_at' => '2026-03-04 19:41:09',
                'updated_at' => '2026-03-04 19:41:09',
            ],
            [
                'department_id' => 1,
                'budget_category_id' => 1,
                'year' => 2026,
                'assigned_amount' => 650000.0000,
                'justification' => 'Recursos para papeleria, mobilario y computo',
                'created_by' => $adminId,
                'approved_by' => null,
                'created_at' => '2026-03-04 19:42:15',
                'updated_at' => '2026-03-04 19:42:15',
            ],
            [
                'department_id' => 2,
                'budget_category_id' => 2,
                'year' => 2026,
                'assigned_amount' => 78000000.0000,
                'justification' => 'Recursos para meterial de producción de los proximos 3 meses',
                'created_by' => $adminId,
                'approved_by' => null,
                'created_at' => '2026-03-04 19:43:02',
                'updated_at' => '2026-03-04 19:43:02',
            ],
            [
                'department_id' => 9,
                'budget_category_id' => 1,
                'year' => 2026,
                'assigned_amount' => 25000000.0000,
                'justification' => 'Recursos para nómina del primer semestre',
                'created_by' => $adminId,
                'approved_by' => null,
                'created_at' => '2026-03-04 19:43:43',
                'updated_at' => '2026-03-04 19:43:43',
            ],
            [
                'department_id' => 8,
                'budget_category_id' => 3,
                'year' => 2026,
                'assigned_amount' => 65000.0000,
                'justification' => 'Recursos para mentenimiento de la red y equipo de computo',
                'created_by' => $adminId,
                'approved_by' => null,
                'created_at' => '2026-03-04 19:44:29',
                'updated_at' => '2026-03-04 19:44:29',
            ],
            [
                'department_id' => 8,
                'budget_category_id' => 1,
                'year' => 2026,
                'assigned_amount' => 3650000.0000,
                'justification' => 'Recursos para pago de servicios: red, telefonia y software',
                'created_by' => $adminId,
                'approved_by' => null,
                'created_at' => '2026-03-04 19:45:34',
                'updated_at' => '2026-03-04 19:45:34',
            ],
            [
                'department_id' => 6,
                'budget_category_id' => 1,
                'year' => 2026,
                'assigned_amount' => 4350000.0000,
                'justification' => 'Recursos para promción y papeleria',
                'created_by' => $adminId,
                'approved_by' => null,
                'created_at' => '2026-03-04 19:46:16',
                'updated_at' => '2026-03-04 19:46:16',
            ],
        ];

        foreach ($assignments as $assignment) {
            BudgetAssignment::updateOrCreate(
                [
                    'department_id' => $assignment['department_id'],
                    'budget_category_id' => $assignment['budget_category_id'],
                    'year' => $assignment['year'],
                ],
                $assignment
            );
        }

        $this->command->info('✓ Asignaciones de presupuesto creadas correctamente (11 registros)');
    }
}
