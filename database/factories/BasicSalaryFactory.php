<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\basic_salaries>
 */
class BasicSalaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => 1,
            'user_id' => \App\Models\User::factory(),
            'basic_salary' => $this->faker->randomFloat(2, 2000, 5000),
        ];
    }
}
