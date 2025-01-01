<?php

namespace Database\Seeders;

use App\Models\Leave;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Leave::create([
            'company_id' => 1,
            'user_id' => 1,
            'leave_type_id' => 1,
            'start_date' => '2024-08-20',
            'end_date' => '2024-08-21',
            'total_days' => 2,
            'is_half_day' => false,
            'reason' => 'Family event',
            'is_paid' => true,
            'status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Leave::create([
            'company_id' => 1,
            'user_id' => 2,
            'leave_type_id' => 2,
            'start_date' => '2024-09-01',
            'end_date' => '2024-09-03',
            'total_days' => 3,
            'is_half_day' => false,
            'reason' => 'Medical leave',
            'is_paid' => true,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Leave::create([
            'company_id' => 1,
            'user_id' => 3,
            'leave_type_id' => 1,
            'start_date' => '2024-08-25',
            'end_date' => '2024-08-25',
            'total_days' => 1,
            'is_half_day' => true,
            'reason' => 'Personal reasons',
            'is_paid' => false,
            'status' => 'rejected',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Leave::create([
            'company_id' => 1,
            'user_id' => 4,
            'leave_type_id' => 3,
            'start_date' => '2024-08-15',
            'end_date' => '2024-08-20',
            'total_days' => 6,
            'is_half_day' => false,
            'reason' => 'Vacation',
            'is_paid' => true,
            'status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Leave::create([
            'company_id' => 1,
            'user_id' => 5,
            'leave_type_id' => 2,
            'start_date' => '2024-10-01',
            'end_date' => '2024-10-02',
            'total_days' => 2,
            'is_half_day' => false,
            'reason' => 'Conference attendance',
            'is_paid' => true,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
