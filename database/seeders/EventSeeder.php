<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'name' => 'Hackathon',
            'description' => 'An exciting hackathon every dev should participate.',
            'category_id' => 1,
            'date' => '2025-06-15 18:00:00',
            'max_tickets' => 100,
            'price' => 45.00
        ]);

        Event::create([
            'name' => 'City Marathon',
            'description' => 'Join us for a marathon through the city streets.',
            'category_id' => 2,
            'date' => '2025-05-10 07:00:00',
            'max_tickets' => 80,
            'price' => 19.00
        ]);
    }
}
