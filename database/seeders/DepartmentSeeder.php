<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'department_name' => 'IT',
            'company_id' => 1, // Assuming company with ID 1 exists
            'created_by' => 1, // Assuming user with ID 1 exists
            'description' => 'Information Technology Department',
        ]);

        Department::create([
            'department_name' => 'HR',
            'company_id' => 1, // Assuming company with ID 1 exists
            'created_by' => 1, // Assuming user with ID 1 exists
            'description' => 'Human Resources Department',
        ]);

        Department::create([
            'department_name' => 'Staff',
            'company_id' => 1, // Assuming company with ID 1 exists
            'created_by' => 1, // Assuming user with ID 1 exists
            'description' => 'General Staff Department',
        ]);
        //Department::factory()->count(2)->create();
    }
}
