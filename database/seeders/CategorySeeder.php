<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['naziv' => 'Izvorska voda', 'opis' => 'Prirodna izvorska voda visokog kvaliteta.'],
            ['naziv' => 'Mineralna voda', 'opis' => 'Mineralna voda sa bogatim mineralnim sastavom.'],
            ['naziv' => 'Gazirana voda', 'opis' => 'Eterna gazirana voda.'],
            ['naziv' => 'Paketi', 'opis' => 'Paketi eterna vode.'],
            
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
