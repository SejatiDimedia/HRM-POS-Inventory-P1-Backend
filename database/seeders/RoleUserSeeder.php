<?php

namespace Database\Seeders;

use App\Models\RoleUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoleUser::create([
            'role_id' => 1, // Adjust the role_id according to your roles
            'user_id' => 1, // Adjust the user_id according to your users
        ]);

        RoleUser::create([
            'role_id' => 2, // Adjust the role_id according to your roles
            'user_id' => 2, // Adjust the user_id according to your users
        ]);

        RoleUser::create([
            'role_id' => 2, // Adjust the role_id according to your roles
            'user_id' => 1, // Adjust the user_id according to your users
        ]);

        RoleUser::create([
            'role_id' => 1, // Adjust the role_id according to your roles
            'user_id' => 2, // Adjust the user_id according to your users
        ]);

        RoleUser::create([
            'role_id' => 1, // Adjust the role_id according to your roles
            'user_id' => 3, // Adjust the user_id according to your users
        ]);
    }
}
