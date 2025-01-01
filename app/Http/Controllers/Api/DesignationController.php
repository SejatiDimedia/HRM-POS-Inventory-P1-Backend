<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    // Get all designations
    public function index()
    {
        $designations = Designation::all();

        return response()->json([
            'message' => 'Designations retrieved successfully',
            'designations' => $designations,
        ], 200);
    }

    // Get a specific designation by ID
    public function show($id)
    {
        $designation = Designation::find($id);

        if (!$designation) {
            return response()->json([
                'message' => 'Designation not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Designation retrieved successfully',
            'designation' => $designation,
        ], 200);
    }

    // Create a new designation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'designation_name' => 'required|string|max:255|unique:designations,designation_name',
            'description' => 'nullable|string',
        ]);

        $user = $request->user();
        $designation = Designation::create([
            'designation_name' => $validated['designation_name'],
            'company_id' => 1, // Single company ID
            'created_by' => $user->id, // Logged-in user's ID
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'message' => 'Designation created successfully',
            'designation' => $designation,
        ], 201);
    }

    // Update an existing designation
    public function update(Request $request, $id)
    {
        $designation = Designation::find($id);

        if (!$designation) {
            return response()->json([
                'message' => 'Designation not found'
            ], 404);
        }

        $validated = $request->validate([
            'designation_name' => 'sometimes|required|string|max:255|unique:designations,designation_name,' . $id,
            'description' => 'sometimes|nullable|string',
        ]);

        $designation->update($validated);

        return response()->json([
            'message' => 'Designation updated successfully',
            'designation' => $designation,
        ], 200);
    }

    // Delete a designation
    public function destroy($id)
    {
        $designation = Designation::find($id);

        if (!$designation) {
            return response()->json([
                'message' => 'Designation not found'
            ], 404);
        }

        $designation->delete();

        return response()->json([
            'message' => 'Designation deleted successfully',
        ], 200);
    }
}
