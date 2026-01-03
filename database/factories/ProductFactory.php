<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'kategorija_id' => Category::factory(),
            'tip_vode' => fake()->regexify('[A-Za-z0-9]{20}'),
            'naziv' => fake()->regexify('[A-Za-z0-9]{30}'),
            'opis' => fake()->text(),
            'cena' => fake()->randomFloat(2, 0, 99999999.99),
            'ambalaza' => fake()->regexify('[A-Za-z0-9]{20}'),
        ];
    }
}
