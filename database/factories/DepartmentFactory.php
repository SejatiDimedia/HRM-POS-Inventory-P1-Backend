<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Department::class;
    public function definition(): array
    {
        return [
            'department_name' => $this->faker->unique()->word,
            'company_id' => 1, // Assuming you have a Company factory
            'created_by' => User::factory(),    // Assuming you have a User factory
            'description' => $this->faker->sentence,
        ];
    }
}
