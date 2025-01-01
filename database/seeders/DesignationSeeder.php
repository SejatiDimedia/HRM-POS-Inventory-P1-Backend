<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Designation::create([
            'designation_name' => 'Manager',
            'company_id' => 1, // Assuming company with ID 1 exists
            'created_by' => 1, // Assuming user with ID 1 exists
            'description' => 'Manages the team and oversees operations.',
        ]);

        Designation::create([
            'designation_name' => 'Developer',
            'company_id' => 1, // Assuming company with ID 1 exists
            'created_by' => 1, // Assuming user with ID 1 exists
            'description' => 'Responsible for developing and maintaining applications.',
        ]);

        Designation::create([
            'designation_name' => 'HR Executive',
            'company_id' => 1, // Assuming company with ID 1 exists
            'created_by' => 1, // Assuming user with ID 1 exists
            'description' => 'Handles recruitment, employee relations, and other HR tasks.',
        ]);
        //Designation::factory()->count(2)->create();
    }
}
