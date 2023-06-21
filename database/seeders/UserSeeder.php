<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin::factory()->count(10)->create();
        $user = User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'admin@admin.com',
            'gender' => 'male',
            'role' => 'super admin',
            'birth_date' => '1998-05-26',
            'status' => 'active',
            'password' => Hash::make('admin@123'),

        ]);
        // Assigning Direct Permissions To A User
        // Additionally, individual permissions can be assigned to the user too. For instance:
        $user->assignRole('super admin');
    }
}
