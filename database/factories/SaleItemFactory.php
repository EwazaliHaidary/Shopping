<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleItemFactory extends Factory
{

   public function definition(): array
{
    $product = Product::inRandomOrder()->first();
    $sale = Sale::inRandomOrder()->first();

    $quantity = fake()->numberBetween(1, 10);
    $unitPrice = $product->sale_price;

    return [
        "product_id" => $product->id,
        "sale_id" => $sale->id,
        "quantity" => $quantity,
        "unit_price" => $unitPrice,
        "subtotal" => $unitPrice * $quantity,
    ];
}
}
