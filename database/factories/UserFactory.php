<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'username' => $this->faker->unique()->userName,
            'profile_image' => $this->faker->imageUrl(),
            'shift_id' => $this->faker->optional()->randomElement(\App\Models\Shift::pluck('id')->toArray()),
            'status' => $this->faker->boolean ? 'Enable' : 'Disable',
            'department_id' => $this->faker->optional()->randomElement(\App\Models\Department::pluck('id')->toArray()),
            'designation_id' => $this->faker->optional()->randomElement(\App\Models\Designation::pluck('id')->toArray()),
            'role_id' => \App\Models\Role::inRandomOrder()->first()->id,
            'warehouse_id' => $this->faker->optional()->randomElement(\App\Models\Warehouse::pluck('id')->toArray()),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'company_id' => 1, // Set to 1 for single company
            'is_superadmin' => $this->faker->boolean,
            'user_type' => $this->faker->randomElement(['employee', 'customer']),
            'login_enabled' => $this->faker->boolean(80), // 80% chance to be true
            //'created_by' => \App\Models\User::inRandomOrder()->first()->id,
        ];
    }
    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
