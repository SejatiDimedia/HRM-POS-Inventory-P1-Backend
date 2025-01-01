<?php

namespace Database\Factories;

use App\Models\Shift;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Shift::class;

    public function definition()
    {
        return [
            'company_id' => 1,
            'shift_name' => $this->faker->randomElement(['Morning', 'Evening', 'Night']),
            'clock_in_time' => $this->faker->time('H:i:s'),
            'clock_out_time' => $this->faker->time('H:i:s'),
            'late_mark_after' => $this->faker->numberBetween(0, 60),
            'early_clock_in_time' => $this->faker->numberBetween(0, 30),
            'allow_clock_out_till' => $this->faker->numberBetween(0, 60),
            'self_clocking' => $this->faker->boolean,
        ];
    }
}
