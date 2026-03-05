<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 1. Catálogos de los que dependen los proveedores
            SupplierTypeSeeder::class,
            SupplierStatusSeeder::class,
            PaymentTermSeeder::class,
            CurrencySeeder::class,

            // 1b. Catálogos de materiales (tipos y unidades)
            MaterialTypeSeeder::class,
            UnitOfMeasureSeeder::class,

            // 2. Proveedores (aún sin el contacto primario)
            SupplierSeeder::class,

            // 3. Contactos (que se asocian a proveedores y actualizan el ID primario)
            SupplierContactSeeder::class,

            // 4. Permisos y otros seeders
            PermissionsSeeder::class,

            // 5. Categorías de materiales con sus atributos específicos
            MaterialCategorySeeder::class,

            // 6. Materiales (que se asocian a categorías)
            MaterialSeeder::class,

            // 7. Departamentos y aprobadores
            DepartmentSeeder::class,
            DepartmentApproverSeeder::class,

            // 8. Categorías de presupuesto
            BudgetCategorySeeder::class,

            // 9. Usuarios con diferentes roles y accesos a departamentos (DEBE IR ANTES de BudgetAssignmentSeeder)
            UserDepartmentSeeder::class,

            // 10. Asignaciones de presupuesto (requiere usuarios creados)
            BudgetAssignmentSeeder::class,

        ]);

        // Crear 10 usuarios aleatorios adicionales con departamentos asignados
        $departments = Department::pluck('id')->toArray();
        if (!empty($departments)) {
            for ($i = 1; $i <= 10; $i++) {
                $firstName = fake()->firstName();
                $lastName = fake()->lastName();
                $email = Str::slug($firstName . '.' . $lastName) . '@company.com';

                User::create([
                    'name' => $firstName . ' ' . $lastName,
                    'email' => $email,
                    'password' => Hash::make('pruebas'),
                    'department_id' => $departments[array_rand($departments)],
                ]);
            }
            $this->command->info('✓ 10 usuarios adicionales creados con departamentos asignados');
        }
    }
}
