<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Role::class;

    public function definition()
    {
        return [
            'company_id' => 1,
            'role_name' => $this->faker->unique()->jobTitle,
            'display_name'=> $this->faker->unique()->jobTitle,
            'description' => $this->faker->sentence,
        ];
    }
}
