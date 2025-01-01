<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    // Get all permissions or filter by module_name
    public function index(Request $request)
    {
        if ($request->has('module_name')) {
            $permissions = Permission::where('module_name', $request->module_name)->get();
        } else {
            $permissions = Permission::all();
        }

        return response()->json([
            'message' => 'Permissions retrieved successfully',
            'permissions' => $permissions,
        ], 200);
    }

    // Get a single permission by ID
    public function show($id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json([
                'message' => 'Permission not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Permission retrieved successfully',
            'permission' => $permission,
        ], 200);
    }

    // Create a new permission
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'module_name' => 'nullable|string|max:255',
        ]);

        $permission = Permission::create($validated);

        return response()->json([
            'message' => 'Permission created successfully',
            'permission' => $permission,
        ], 201);
    }

    // Update an existing permission
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json([
                'message' => 'Permission not found',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:permissions,name,' . $id,
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'module_name' => 'nullable|string|max:255',
        ]);

        $permission->update($validated);

        return response()->json([
            'message' => 'Permission updated successfully',
            'permission' => $permission,
        ], 200);
    }

    // Delete a permission
    public function destroy($id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json([
                'message' => 'Permission not found',
            ], 404);
        }

        $permission->delete();

        return response()->json([
            'message' => 'Permission deleted successfully',
        ], 200);
    }
}
