<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
  
    public function definition(): array
    {
        return [
            "category_id" => Category::inRandomOrder()->value('id'),            "name" => fake()->word(),
            'sku' => fake()->unique()->bothify('SKU-####'),
            'description' => fake()->sentence(),
            'purchase_price' =>fake()->numberBetween(200, 1000),
            'sale_price' =>fake()->numberBetween(400, 1200),
            'stock' => fake()-> numberBetween(20,50),
            'alert_quantity' =>fake()->numberBetween(5,13),
            'is_active' => fake()->boolean(85)

        ];
    }
}
