<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Make sure to use the User model
use Illuminate\Support\Facades\Hash; // Import Hash facade

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user
        User::create([
            'name' => 'Admin User', // Set the admin user's name
            'email' => 'admin@example.com', // Set a valid email address
            'password' => Hash::make('admin123'), // Set a secure password
            'is_admin' => true, // Ensure this user is marked as an admin
        ]);
    }
}
