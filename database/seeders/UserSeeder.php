<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create talent users
        User::create([
            'name' => 'Talent 1',
            'email' => 'talent1@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'avatar' => null,
            'role' => 'talent',
        ]);

        User::create([
            'name' => 'Talent 2',
            'email' => 'talent2@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'avatar' => null,
            'role' => 'talent',
        ]);

        // Create customer users
        User::create([
            'name' => 'Customer 1',
            'email' => 'customer1@example.com',
            'password' => Hash::make('password'),
            'phone' => '082234567890',
            'avatar' => null,
            'role' => 'customer',
        ]);

        User::create([
            'name' => 'Customer 2',
            'email' => 'customer2@example.com',
            'password' => Hash::make('password'),
            'phone' => '082234567891',
            'avatar' => null,
            'role' => 'customer',
        ]);
    }
}
