<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create a few doctors
        User::factory()->count(3)->create([
            'role' => 'doctor',
        ]);

        // Create a bunch of students
        User::factory()->count(10)->create([
            'role' => 'student',
        ]);
    }
}