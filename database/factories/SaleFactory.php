<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class SaleFactory extends Factory
{

    public function definition(): array
    {
        $total_price = fake()->randomFloat(2,300,5000);
        $discount = fake()->randomFloat(2,0,400);
        return [
            "user_id" => User::inRandomOrder()->value('id'),
            "customer_id" => Customer::inRandomOrder()->value('id'),
            "total_price"=>$total_price,
            "discount" =>$discount,
            "final_price" => $total_price - $discount,
            "status" => 'completed',
            "notes" => fake()->optional()-> sentence(15)

        ];
    }
}
