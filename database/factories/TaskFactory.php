<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
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
            'employee_id' => Employee::get()->random()->id,
            'duration' => $this->faker->randomNumber(2),
            'is_active' => $this->faker->boolean,
            'completed' => $this->faker->boolean,
            'admin_id' => 1,
        ];
    }
}
