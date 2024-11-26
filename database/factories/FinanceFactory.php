<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Finance>
 */
class FinanceFactory extends Factory
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
            'company_id' => Company::get()->random()->id,
            'category' => $this->faker->word,
            'type' => $this->faker->word,
            'date' => $this->faker->date(),
            'gross' => $this->faker->randomFloat(),
            'net' => $this->faker->randomFloat(),
            'vat' => $this->faker->randomFloat(),
            'description' => $this->faker->text,
            'is_active' => $this->faker->boolean,
            'admin_id' => 1
        ];
    }
}
