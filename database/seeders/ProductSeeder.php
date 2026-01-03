<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->info('Nema kategorija! Pokreni prvo CategorySeeder.');
            return;
        }

        Product::create([
            'kategorija_id' => $categories->first()->id,
            'tip_vode' => 'Izvorska',
            'naziv' => 'Voda Eterna 0.5L',
            'opis' => 'Osvežavajuća izvorska voda.',
            'cena' => 50.00,
            'ambalaza' => 'PET',
        ]);

        Product::create([
            'kategorija_id' => $categories->first()->id,
            'tip_vode' => 'Mineralna',
            'naziv' => 'Voda Eterna Mineral 1L',
            'opis' => 'Prirodna mineralna voda.',
            'cena' => 80.00,
            'ambalaza' => 'PET',
        ]);

        Product::create([
            'kategorija_id' => $categories->last()->id,
            'tip_vode' => 'Gazirana',
            'naziv' => 'Eterna Gazirana 0.5L',
            'opis' => 'Gazirana voda.',
            'cena' => 60.00,
            'ambalaza' => 'PET',
        ]);
    }
}
