<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Holiday::create([
           'company_id' => 1,
            'name' => 'New Year\'s Day',
            'year' => 2024,
            'month' => 1,
            'date' => '2024-01-01',
            'is_weekend' => false,
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Holiday::create([
            'company_id' => 1,
            'name' => 'Christmas Day',
            'year' => 2024,
            'month' => 12,
            'date' => '2024-12-25',
            'is_weekend' => true,
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
         ]);

    }
}
