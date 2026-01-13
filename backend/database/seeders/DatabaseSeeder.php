<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

            // 2. Proveedores (aún sin el contacto primario)
            SupplierSeeder::class,

            // 3. Contactos (que se asocian a proveedores y actualizan el ID primario)
            SupplierContactSeeder::class,

            // 4. Permisos y otros seeders
            PermissionsSeeder::class,
            PapermillPermissionsSeeder::class,
            AssignPapermillPermissionsSeeder::class,
            AssignPapermillPermissionsToRoleSeeder::class,
        ]);
    }
}
