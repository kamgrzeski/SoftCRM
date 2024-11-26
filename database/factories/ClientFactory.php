<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'section' => $this->faker->word,
            'budget' => $this->faker->randomFloat(2, 1000, 100000),
            'location' => $this->faker->word,
            'zip' => $this->faker->postcode,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'is_active' => $this->faker->boolean,
            'admin_id' => 1
        ];
    }
}
