<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
            'name' => $this->faker->name,
            'category' => $this->faker->name,
            'count' => $this->faker->randomNumber(3),
            'price' => $this->faker->randomNumber(3),
            'is_active' => $this->faker->boolean,
            'admin_id' => 1,
        ];
    }
}
