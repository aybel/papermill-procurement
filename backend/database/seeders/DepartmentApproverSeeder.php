<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Department;

class DepartmentApproverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegurarse de que la tabla esté vacía antes de sembrar
        DB::table('department_approvers')->truncate();

        // Obtener algunos departamentos y usuarios para asignar
        // Esto asume que los seeders de User y Department ya se ejecutaron
        $user1 = User::find(1);
        $user2 = User::find(2);
        $user3 = User::find(3);

        $deptProd = Department::where('code', 'PROD')->first();
        $deptComp = Department::where('code', 'COMP')->first();
        $deptAdmin = Department::where('code', 'ADMIN')->first();

        if ($user1 && $user2 && $user3 && $deptProd && $deptComp && $deptAdmin) {
            DB::table('department_approvers')->insert([
                // Aprobador Nivel 1 para Producción, con límite de $5,000
                [
                    'department_id' => $deptProd->id,
                    'user_id' => $user1->id,
                    'title' => 'Gerente de Producción',
                    'approval_level' => 1,
                    'approval_limit' => 5000.00,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // Aprobador Nivel 2 para Producción (Director), sin límite
                [
                    'department_id' => $deptProd->id,
                    'user_id' => $user2->id,
                    'title' => 'Director de Operaciones',
                    'approval_level' => 2,
                    'approval_limit' => null,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // Aprobador para Compras
                [
                    'department_id' => $deptComp->id,
                    'user_id' => $user2->id,
                    'title' => 'Gerente de Compras',
                    'approval_level' => 1,
                    'approval_limit' => 10000.00,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                // Aprobador para Administración (Gerente General)
                [
                    'department_id' => $deptAdmin->id,
                    'user_id' => $user3->id,
                    'title' => 'Gerente General',
                    'approval_level' => 1,
                    'approval_limit' => null,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        } else {
            $this->command->warn('No se encontraron suficientes usuarios o departamentos para asignar aprobadores.');
        }
    }
}
