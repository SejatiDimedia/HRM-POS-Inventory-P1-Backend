<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Permission::factory(10)->create();

        $permissions = [
            // Shifts
            ['name' => 'shifts_view', 'module_name' => 'shifts', 'display_name' => 'View Shifts'],
            ['name' => 'shifts_add', 'module_name' => 'shifts', 'display_name' => 'Add Shifts'],
            ['name' => 'shifts_edit', 'module_name' => 'shifts', 'display_name' => 'Edit Shifts'],
            ['name' => 'shifts_delete', 'module_name' => 'shifts', 'display_name' => 'Delete Shifts'],

            // Departments
            ['name' => 'departments_view', 'module_name' => 'departments', 'display_name' => 'View Departments'],
            ['name' => 'departments_add', 'module_name' => 'departments', 'display_name' => 'Add Departments'],
            ['name' => 'departments_edit', 'module_name' => 'departments', 'display_name' => 'Edit Departments'],
            ['name' => 'departments_delete', 'module_name' => 'departments', 'display_name' => 'Delete Departments'],

            // Designations
            ['name' => 'designations_view', 'module_name' => 'designations', 'display_name' => 'View Designations'],
            ['name' => 'designations_add', 'module_name' => 'designations', 'display_name' => 'Add Designations'],
            ['name' => 'designations_edit', 'module_name' => 'designations', 'display_name' => 'Edit Designations'],
            ['name' => 'designations_delete', 'module_name' => 'designations', 'display_name' => 'Delete Designations'],

            // Leaves
            ['name' => 'leaves_view', 'module_name' => 'leaves', 'display_name' => 'View Leaves'],
            ['name' => 'leaves_add', 'module_name' => 'leaves', 'display_name' => 'Add Leaves'],
            ['name' => 'leaves_edit', 'module_name' => 'leaves', 'display_name' => 'Edit Leaves'],
            ['name' => 'leaves_delete', 'module_name' => 'leaves', 'display_name' => 'Delete Leaves'],

            // Payroll
            ['name' => 'payroll_view', 'module_name' => 'payroll', 'display_name' => 'View Payroll'],
            ['name' => 'payroll_add', 'module_name' => 'payroll', 'display_name' => 'Add Payroll'],
            ['name' => 'payroll_edit', 'module_name' => 'payroll', 'display_name' => 'Edit Payroll'],
            ['name' => 'payroll_delete', 'module_name' => 'payroll', 'display_name' => 'Delete Payroll'],

            // Holidays
            ['name' => 'holidays_view', 'module_name' => 'holidays', 'display_name' => 'View Holidays'],
            ['name' => 'holidays_add', 'module_name' => 'holidays', 'display_name' => 'Add Holidays'],
            ['name' => 'holidays_edit', 'module_name' => 'holidays', 'display_name' => 'Edit Holidays'],
            ['name' => 'holidays_delete', 'module_name' => 'holidays', 'display_name' => 'Delete Holidays'],

            // Attendance
            ['name' => 'attendance_view', 'module_name' => 'attendance', 'display_name' => 'View Attendance'],
            ['name' => 'attendance_add', 'module_name' => 'attendance', 'display_name' => 'Add Attendance'],
            ['name' => 'attendance_edit', 'module_name' => 'attendance', 'display_name' => 'Edit Attendance'],
            ['name' => 'attendance_delete', 'module_name' => 'attendance', 'display_name' => 'Delete Attendance'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
