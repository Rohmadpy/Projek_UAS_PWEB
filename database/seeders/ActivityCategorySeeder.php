<?php

namespace Database\Seeders;

use App\Models\ActivityCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ActivityCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Ngopi Santai', 'icon' => 'coffee'],
            ['name' => 'Nugas', 'icon' => 'book-open'],
            ['name' => 'Kerja Kelompok', 'icon' => 'users'],
            ['name' => 'Rapat', 'icon' => 'briefcase'],
            ['name' => 'Event Kecil', 'icon' => 'calendar-event'],
        ];

        foreach ($categories as $category) {
            ActivityCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
            ]);
        }
    }
}
