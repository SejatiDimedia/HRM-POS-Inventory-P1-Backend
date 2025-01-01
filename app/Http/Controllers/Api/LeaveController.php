<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leave = Leave::with(['user', 'leaveType'])->get();

        return response([
            'message' => 'Leave requests retrieved successfully',
            'data' => $leave,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'total_days' => 'required|integer|min:1',
            'is_half_day' => 'nullable|boolean',
            'reason' => 'required|string',
            'is_paid' => 'nullable|boolean',
            'status' => 'nullable|string|in:pending,approved,rejected',
        ]);

        $leave = new Leave();
        $leave->company_id = 1;
        $leave->user_id = $request->user_id;
        $leave->leave_type_id = $request->leave_type_id;
        $leave->start_date = $request->start_date;
        $leave->end_date = $request->end_date;
        $leave->total_days = $request->total_days;
        $leave->is_half_day = $request->is_half_day ?? false;
        $leave->reason = $request->reason;
        $leave->is_paid = $request->is_paid ?? false;
        $leave->status = $request->status ?? 'pending';
        $leave->save();

        $leave->load(['user', 'leaveType']);

        return response([
            'message' => 'Leave request created successfully',
            'data' => $leave,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return response([
                'message' => 'Leave request not found',
            ], 404);
        }

        return response([
            'message' => 'Leave request retrieved successfully',
            'data' => $leave,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'total_days' => 'required|integer|min:1',
            'is_half_day' => 'nullable|boolean',
            'reason' => 'required|string',
            'is_paid' => 'nullable|boolean',
            'status' => 'nullable|string|in:pending,approved,rejected',
        ]);

        $leave = Leave::find($id);

        if (!$leave) {
            return response([
                'message' => 'Leave request not found',
            ], 404);
        }

        $leave->company_id = 1;
        $leave->user_id = $request->user_id;
        $leave->leave_type_id = $request->leave_type_id;
        $leave->start_date = $request->start_date;
        $leave->end_date = $request->end_date;
        $leave->total_days = $request->total_days;
        $leave->is_half_day = $request->is_half_day ?? false;
        $leave->reason = $request->reason;
        $leave->is_paid = $request->is_paid ?? false;
        $leave->status = $request->status ?? 'pending';
        $leave->save();

        $leave->load(['user', 'leaveType']);

        return response([
            'message' => 'Leave request updated successfully',
            'data' => $leave,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return response([
                'message' => 'Leave request not found',
            ], 404);
        }

        $leave->delete();

        return response([
            'message' => 'Leave request deleted successfully',
        ], 200);
    }
}
