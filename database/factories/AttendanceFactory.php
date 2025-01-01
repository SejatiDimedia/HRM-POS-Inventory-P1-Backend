<?php

namespace Database\Factories;

use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Attendance::class;

    public function definition()
    {
        return [
            'company_id' => 1,
            'date' => $this->faker->date(),
            'is_holiday' => $this->faker->boolean(),
            'is_leave' => $this->faker->boolean(),
            'user_id' => User::factory(),
            'leave_id' => $this->faker->optional()->numberBetween(1, 5),
            'leave_type_id' => LeaveType::factory(),
            'holiday_id' => $this->faker->optional()->numberBetween(1, 2),
            'clock_in_date_time' => $this->faker->optional()->dateTime(),
            'clock_out_date_time' => $this->faker->optional()->dateTime(),
            'total_duration' => $this->faker->optional()->numberBetween(0, 480),
            'is_late' => $this->faker->boolean(),
            'is_half_day' => $this->faker->boolean(),
            'is_paid' => $this->faker->boolean(),
            'status' => $this->faker->randomElement(['present', 'absent', 'not marked', 'leave']),
            'reason' => $this->faker->optional()->text(),
        ];
    }
}
