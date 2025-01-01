<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    // Get all departments
    public function index()
    {
        $departments = Department::all();

        return response()->json([
            'message' => 'Departments retrieved successfully',
            'departments' => $departments,
        ], 200);
    }

    // Get a single department by ID
    public function show($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'message' => 'Department not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Department retrieved successfully',
            'department' => $department,
        ], 200);
    }

    // Create a new department
    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:255|unique:departments',
            'description' => 'nullable|string',
        ]);

        $user = $request->user();
        $department = Department::create([
            'department_name' => $validated['department_name'],
            'company_id' => 1, // Single company ID
            'created_by' => $user->id, // Logged-in user's ID
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'message' => 'Department created successfully',
            'department' => $department,
        ], 201);
    }

    // Update an existing department
    public function update(Request $request, $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'message' => 'Department not found',
            ], 404);
        }

        $validated = $request->validate([
            'department_name' => 'sometimes|required|string|max:255|unique:departments,department_name,' . $id,
            'description' => 'sometimes|nullable|string',
        ]);

        $department->update($validated);

        return response()->json([
            'message' => 'Department updated successfully',
            'department' => $department,
        ], 200);
    }

    // Delete a department
    public function destroy($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'message' => 'Department not found',
            ], 404);
        }

        $department->delete();

        return response()->json([
            'message' => 'Department deleted successfully',
        ], 200);
    }
}
