<?php

namespace Database\Seeders;

use App\Models\Designation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CompanySeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            PermissionRoleSeeder::class,
            ShiftSeeder::class,
            UserSeeder::class,
            DepartmentSeeder::class,
            DesignationSeeder::class,
            HolidaySeeder::class,
            RoleUserSeeder::class,
            BasicSalarySeeder::class,
            LeaveTypeSeeder::class,
            LeaveSeeder::class,
            AttendanceSeeder::class,
            WarehouseSeeder::class,
            PayrollSeeder::class,
        ]);
    }
}
