<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Designation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Designation>
 */
class DesignationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Designation::class;

    public function definition()
    {
        return [
            'designation_name' => $this->faker->unique()->word,
            'company_id' => 1, // Assuming you have a Company factory
            'created_by' => User::factory(),    // Assuming you have a User factory
            'description' => $this->faker->sentence,
        ];
    }
}
