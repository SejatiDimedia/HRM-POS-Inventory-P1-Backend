<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Permission::class;

    public function definition()
    {
        return [
            // 'role_id' => \App\Models\Role::inRandomOrder()->first()->id,
            // 'feature' => $this->faker->randomElement(['shift', 'department', 'designations', 'leaves', 'payroll', 'holiday', 'attendance']),
            // 'view' => $this->faker->boolean,
            // 'add' => $this->faker->boolean,
            // 'edit' => $this->faker->boolean,
            // 'delete' => $this->faker->boolean,
            'name' => $this->faker->unique()->word,
            'display_name' => $this->faker->word,
            'module_name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ];
    }
}
