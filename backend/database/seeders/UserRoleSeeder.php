<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Find the first user
        $user = User::first();

        // Find the Admin role
        $adminRole = Role::where('name', 'Admin')->first();

        // Assign the Admin role to the user if both exist
        if ($user && $adminRole) {
            $user->assignRole($adminRole);
        }
    }
}
