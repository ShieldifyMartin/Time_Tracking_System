<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'salary' => $this->faker->randomFloat(2, 30000, 100000),
            'hired_since' => $this->faker->date,
            'working_hours_per_day' => $this->faker->numberBetween(6, 10),
            'job_title' => $this->faker->word,
            'notes' => $this->faker->sentence,
            'is_active' => $this->faker->boolean,
            'total_hours_worked' => $this->faker->numberBetween(0, 2000),
        ];
    }
}
