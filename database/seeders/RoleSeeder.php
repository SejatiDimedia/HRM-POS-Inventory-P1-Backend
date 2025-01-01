<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'company_id'=> 1,
            'role_name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'Administration',
        ]);
        Role::factory()->count(3)->create();
    }
}
