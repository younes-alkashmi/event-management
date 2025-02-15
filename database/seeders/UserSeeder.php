<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => bcrypt('manager123'),
            'role' => 'manager',
        ]);

        User::create([
            'name' => 'Basic User',
            'email' => 'user@example.com',
            'password' => bcrypt('user1234'),
            'role' => 'basic',
        ]);
    }
}
