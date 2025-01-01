<?php

namespace Database\Factories;

use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LeaveType>
 */
class LeaveTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = LeaveType::class;

    public function definition()
    {
        return [
            'company_id' => 1,
            'name' => $this->faker->word,
            'is_paid' => $this->faker->boolean,
            'total_leaves' => $this->faker->numberBetween(1, 30),
            'max_leaves_per_month' => $this->faker->optional()->numberBetween(1, 10),
            'created_by' => User::factory(),
        ];
    }
}
