<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
use App\Models\Project;
use App\Models\User;

class WorkloadFactory extends Factory
{
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'project_id' => Project::factory(),
            'hours_worked' => $this->faker->numberBetween(1, 8),
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence,
            'created_by' => 1,
        ];
    }
}