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
        // Seed some users
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('adminpassword'),
                'phone_number' => '123456789',
                'gender' => 'male',
                'address' => '123 Admin Street',
                'type' => 'admin',
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('userpassword'),
                'phone_number' => '987654321',
                'gender' => 'female',
                'address' => '456 User Street',
                'type' => 'user',
            ],
            // You can add more users here if needed
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
