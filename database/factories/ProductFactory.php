<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ProductFactory extends Factory
{

    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 10, 100),
            'stock' => fake()->numberBetween(1, 100),
        ];
    }
}
