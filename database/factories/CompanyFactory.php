<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
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
            'tax_number' => $this->faker->randomNumber(8),
            'phone' => $this->faker->phoneNumber,
            'city' => $this->faker->city,
            'billing_address' => $this->faker->address,
            'country' => $this->faker->country,
            'postal_code' => $this->faker->postcode,
            'employees_size' => $this->faker->randomNumber(3),
            'fax' => $this->faker->phoneNumber,
            'description' => $this->faker->text,
            'client_id' => Client::get()->random()->id,
            'admin_id' => 1,
            'created_at' => $this->faker->dateTime,
            'is_active' => $this->faker->boolean,
        ];
    }
}
