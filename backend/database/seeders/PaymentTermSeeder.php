<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentTermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('payment_terms')->truncate();
        Schema::enableForeignKeyConstraints();
        DB::table('payment_terms')->insert([
            ['id' => 1, 'code' => 'IMMEDIATE', 'name' => "Pago Inmediato", 'description' => 'Pago Inmediato', 'days' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'code' => 'NET15', 'name' => "Pago a 15 días", 'description' => 'Pago a 15 días', 'days' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'code' => 'NET30', 'name' => "Pago a 30 días", 'description' => 'Pago a 30 días', 'days' => 30, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'code' => 'NET45', 'name' => "Pago a 45 días", 'description' => 'Pago a 45 días', 'days' => 45, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'code' => 'NET60', 'name' => "Pago a 60 días", 'description' => 'Pago a 60 días', 'days' => 60, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'code' => 'NET90', 'name' => "Pago a 90 días", 'description' => 'Pago a 90 días', 'days' => 90, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
