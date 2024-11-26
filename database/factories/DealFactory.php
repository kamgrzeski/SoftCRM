<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deal>
 */
class DealFactory extends Factory
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
            'start_time' => $this->faker->dateTime,
            'end_time' => $this->faker->dateTime,
            'company_id' => Company::get()->random()->id,
            'is_active' => $this->faker->boolean,
            'admin_id' => 1,
        ];
    }
}
