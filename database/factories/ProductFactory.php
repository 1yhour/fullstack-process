<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()->name(),
            "price" => fake()->randomFloat(2, 5, 999.99),
            "category_id" => fake()->numberBetween(1,3),
            "user_id" => fake()->numberBetween(1,3),

        ];
    }
}
