<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaveTypes = LeaveType::all();

        return response([
            'message' => 'Leave types retrieved successfully',
            'data' => $leaveTypes,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'is_paid' => 'required|boolean',
            'total_leaves' => 'required|integer|min:1',
            'max_leaves_per_month' => 'nullable|integer|min:1',
            'created_by' => 'nullable|exists:users,id',
        ]);

        $leaveType = LeaveType::create([
            'company_id' => 1,
            'name' => $request->name,
            'is_paid' => $request->is_paid,
            'total_leaves' => $request->total_leaves,
            'max_leaves_per_month' => $request->max_leaves_per_month,
            'created_by' => $request->created_by,
        ]);

        return response([
            'message' => 'Leave type created successfully',
            'data' => $leaveType,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $leaveType = LeaveType::find($id);

        if (!$leaveType) {
            return response([
                'message' => 'Leave type not found',
            ], 404);
        }

        return response([
            'message' => 'Leave type retrieved successfully',
            'data' => $leaveType,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'is_paid' => 'required|boolean',
            'total_leaves' => 'required|integer|min:1',
            'max_leaves_per_month' => 'nullable|integer|min:1',
            'created_by' => 'nullable|exists:users,id',
        ]);

        $leaveType = LeaveType::find($id);

        if (!$leaveType) {
            return response([
                'message' => 'Leave type not found',
            ], 404);
        }

        $leaveType->update([
            'company_id' => 1,
            'name' => $request->name,
            'is_paid' => $request->is_paid,
            'total_leaves' => $request->total_leaves,
            'max_leaves_per_month' => $request->max_leaves_per_month,
            'created_by' => $request->created_by,
        ]);

        return response([
            'message' => 'Leave type updated successfully',
            'data' => $leaveType,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $leaveType = LeaveType::find($id);

        if (!$leaveType) {
            return response([
                'message' => 'Leave type not found',
            ], 404);
        }

        $leaveType->delete();

        return response([
            'message' => 'Leave type deleted successfully',
        ], 200);
    }
}
