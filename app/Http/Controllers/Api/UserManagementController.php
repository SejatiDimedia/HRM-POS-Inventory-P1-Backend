<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    // Mendapatkan semua Role dan Permission
    public function index()
    {
        // Ambil semua Role beserta relasi permissions-nya
        $roles = Role::with('permissions')->get();

        // Kembalikan response JSON dengan status 200 (OK)
        return response()->json([
            'message' => 'Roles retrieved successfully',
            'roles' => $roles,
        ], 200);
    }

    // Mendapatkan Role dan Permission berdasarkan ID
    public function show($roleId)
    {
        // Temukan Role berdasarkan ID beserta relasi permissions-nya
        $role = Role::with('permissions')->findOrFail($roleId);

        // Kembalikan response JSON dengan status 200 (OK)
        return response()->json([
            'message' => 'Role retrieved successfully',
            'role' => $role,
        ], 200);
    }

    // Membuat Role baru
    public function store(Request $request)
    {
        // Melakukan validasi data yang dikirim dalam request
        $validated = $request->validate([
            'role_name' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string',
        ]);

        // Membuat Role baru dengan data yang sudah divalidasi
        $role = Role::create([
            'company_id' => 1, // Set company_id to 1 because single company
            'role_name' => $validated['role_name'],
            'display_name' => $validated['role_name'], // Set display_name from role_name
            'description' => $validated['description'],
        ]);

        // Jika permissions ada dalam request, hubungkan permissions tersebut dengan Role yang baru dibuat
        if (isset($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        // Ambil kembali Role yang baru dibuat beserta relasi permissions-nya
        $role = Role::with('permissions')->findOrFail($role->id);


        return response()->json([
            'message' => 'Role created successfully',
            'role' => $role,
        ], 201);
    }

    // Menampilkan halaman edit (dalam konteks API, ini hanya pengambilan data yang perlu diedit)
    public function edit($roleId)
    {
        // Temukan Role berdasarkan ID beserta relasi permissions-nya
        $role = Role::with('permissions')->findOrFail($roleId);

        // Kembalikan response JSON dengan status 200 (OK)
        return response()->json([
            'message' => 'Role edit data retrieved successfully',
            'role' => $role,
        ], 200);
    }

    // Mengedit Role termasuk permissions
    public function update(Request $request, $roleId)
    {
        // Temukan Role berdasarkan ID
        $role = Role::findOrFail($roleId);

        // Melakukan validasi data yang dikirim dalam request
        $validated = $request->validate([
            'role_name' => 'sometimes|required|string|max:255|unique:roles,role_name,' . $roleId, // role_name harus unik tapi bisa diabaikan jika tidak diubah
            'display_name' => 'sometimes|required|string|max:255', // display_name bisa diubah, wajib jika disertakan
            'description' => 'sometimes|nullable|string', // description bisa diubah, opsional
            'permissions' => 'nullable|array', // permissions opsional, harus berupa array
            'permissions.*' => 'exists:permissions,id', // Setiap elemen dalam array permissions harus ada dalam tabel permissions
        ]);

        // Update data Role dengan data yang divalidasi
        $role->update($validated);

        // Jika permissions disertakan, update permissions untuk Role ini
        if (isset($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        // Ambil kembali Role yang sudah diupdate beserta relasi permissions-nya
        $role = Role::with('permissions')->findOrFail($roleId);


        return response()->json([
            'message' => 'Role updated successfully',
            'role' => $role,
        ], 200);
    }

    // Menghapus Role
    public function destroy($roleId)
    {
        // Temukan Role berdasarkan ID
        $role = Role::findOrFail($roleId);
        // Hapus Role
        $role->delete();

        // Kembalikan response JSON dengan status 200 (OK)
        return response()->json([
            'message' => 'Role deleted successfully',
        ], 200);
    }
}
