<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            ['name' => 'WiFi', 'icon' => 'wifi'],
            ['name' => 'Stop Kontak', 'icon' => 'plug'],
            ['name' => 'Ruangan Meeting', 'icon' => 'users'],
            ['name' => 'Outdoor', 'icon' => 'tree'],
            ['name' => 'Event Hall', 'icon' => 'calendar'],
            ['name' => 'AC', 'icon' => 'wind'],
            ['name' => 'Parkir', 'icon' => 'car'],
            ['name' => 'Musholla', 'icon' => 'mosque'],
            ['name' => 'Toilet', 'icon' => 'restroom'],
            ['name' => 'Smoking Area', 'icon' => 'smoking'],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}
