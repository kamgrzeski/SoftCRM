<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'quantity' => $this->faker->randomNumber(2),
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'date_of_payment' => $this->faker->dateTimeThisYear(),
            'product_id' => Product::get()->random()->id,
            'admin_id' => 1,
        ];
    }
}
