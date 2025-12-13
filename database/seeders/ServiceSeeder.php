<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        // Services for Talent 1
        Service::create([
            'user_id' => 2, // Talent 1
            'name' => 'Web Design Consultation',
            'description' => 'Get professional advice on web design',
            'price' => 100,
        ]);

        Service::create([
            'user_id' => 2,
            'name' => 'UI/UX Audit',
            'description' => 'Complete audit of your UI/UX design',
            'price' => 250,
        ]);

        // Services for Talent 2
        Service::create([
            'user_id' => 3, // Talent 2
            'name' => 'App Development',
            'description' => 'Full stack app development',
            'price' => 500,
        ]);

        Service::create([
            'user_id' => 3,
            'name' => 'Technical Consultation',
            'description' => 'Technical advice for your project',
            'price' => 150,
        ]);
    }
}
