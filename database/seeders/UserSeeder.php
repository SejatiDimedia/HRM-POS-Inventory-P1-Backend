<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating a Super Admin user
        User::factory()->create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'profile_image' => 'https://via.placeholder.com/150',
            'email' => 'superadmin@admin.com',
            'password' => Hash::make('12345678'),
            'shift_id' => null,
            'status' => 'Enable',
            'department_id' => null,
            'designation_id' => null,
            'role_id' => \App\Models\Role::where('role_name', 'Admin')->first()->id,
            'warehouse_id' => null,
            'phone' => '085895226892',
            'address' => 'Surabaya, East Java, Indonesia',
            'company_id' => 1,
            'is_superadmin' => 1,
            'user_type' => 'employee',
            'login_enabled' => 1,
           // 'created_by' => 1, // Assuming Super Admin is created by itself
        ]);

        // Creating additional users
        User::factory()->create([
            'name' => 'Bahri',
            'username' => 'bahri_admin',
            'profile_image' => 'https://via.placeholder.com/150',
            'email' => 'bahri@karyawan.com',
            'password' => Hash::make('12345678'),
            'shift_id' => null,
            'status' => 'Enable',
            'department_id' => null,
            'designation_id' => null,
            'role_id' => \App\Models\Role::where('role_name', 'Admin')->first()->id,
            'warehouse_id' => null,
            'phone' => '085895226892',
            'address' => 'Surabaya, East Java, Indonesia',
            'company_id' => 1,
            'is_superadmin' => 0,
            'user_type' => 'employee',
            'login_enabled' => 1,
            //'created_by' => 1, // Created by Super Admin
        ]);

        User::factory()->create([
            'name' => 'fic20',
            'username' => 'fic20',
            'profile_image' => 'https://via.placeholder.com/150',
            'email' => 'fic20@admin.com',
            'password' => Hash::make('12345678'),
            'shift_id' => null,
            'status' => 'Enable',
            'department_id' => null,
            'designation_id' => null,
            'role_id' => \App\Models\Role::where('role_name', 'Admin')->first()->id,
            'warehouse_id' => null,
            'phone' => '085895226892',
            'address' => 'Ngawi, East Java, Indonesia',
            'company_id' => 1,
            'is_superadmin' => 0,
            'user_type' => 'employee',
            'login_enabled' => 1,
            //'created_by' => 1, // Created by Super Admin
        ]);

        // Create 4 additional users
        //User::factory(4)->create();
    }
}
