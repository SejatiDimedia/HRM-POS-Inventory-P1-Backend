<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    // Mendapatkan semua staff members
    public function index()
    {
        $users = User::with(['shift', 'department', 'designation', 'roles'])->get();

        return response([
            'message' => 'Staff members retrieved successfully',
            'data' => $users,
        ], 200);
    }

    // Membuat staff member baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'is_superadmin' => 'nullable|boolean',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'role_id' => 'required|exists:roles,id',
            'user_type' => 'nullable|string',
            // 'is_walkin_customer' => 'nullable|boolean',
            'login_enabled' => 'nullable|boolean',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:15',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'nullable|string',
            // 'shipping_address' => 'nullable|string',
            'status' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'shift_id' => 'required|exists:shifts,id',
        ]);

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('images/staff', $filename, 'public');
            $validated['profile_image'] = $filePath;
        }

        $user = new User($validated);
        $user->company_id = 1; // Set to single company
        $user->password = Hash::make($request->password);
        $user->save();

        $user->roles()->sync([$request->role_id]);

        $user->load(['shift', 'department', 'designation', 'roles']);

        return response([
            'message' => 'Staff member created successfully',
            'data' => $user,
        ], 201);
    }


    // Mendapatkan staff member berdasarkan ID
    public function show($id)
    {
        $user = User::with(['shift', 'department', 'designation', 'roles'])->find($id);

        if (!$user) {
            return response([
                'message' => 'Staff member not found',
            ], 404);
        }

        return response([
            'message' => 'Staff member retrieved successfully',
            'data' => $user,
        ], 200);
    }


    // Mengupdate staff member yang ada
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'username' => 'sometimes|required|string|max:255|unique:users,username,' . $id,
            'is_superadmin' => 'sometimes|nullable|boolean',
            'warehouse_id' => 'sometimes|nullable|exists:warehouses,id',
            'role_id' => 'sometimes|required|exists:roles,id',
            'user_type' => 'sometimes|nullable|string',
            // 'is_walkin_customer' => 'sometimes|nullable|boolean',
            'login_enabled' => 'sometimes|nullable|boolean',
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|nullable|string|min:8',
            'phone' => 'sometimes|required|string|max:15',
            'profile_image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'sometimes|nullable|string',
            // 'shipping_address' => 'sometimes|nullable|string',
            'status' => 'sometimes|nullable|string',
            'department_id' => 'sometimes|required|exists:departments,id',
            'designation_id' => 'sometimes|required|exists:designations,id',
            'shift_id' => 'sometimes|required|exists:shifts,id',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response([
                'message' => 'Staff member not found',
            ], 404);
        }

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('images/staff', $filename, 'public');
            $validated['profile_image'] = $filePath;
        }

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        if ($request->has('role_id')) {
            $user->roles()->sync([$request->role_id]);
        }

        return response([
            'message' => 'Staff member updated successfully',
            'data' => $user,
        ], 200);
    }

    // Menghapus staff member
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response([
                'message' => 'Staff member not found',
            ], 404);
        }

        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->delete();

        return response([
            'message' => 'Staff member deleted successfully',
        ], 200);
    }
}
