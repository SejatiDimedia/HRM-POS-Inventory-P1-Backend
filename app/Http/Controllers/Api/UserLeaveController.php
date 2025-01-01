<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;

class UserLeaveController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'total_days' => 'required|integer|min:1',
            'is_half_day' => 'nullable|boolean',
            'reason' => 'required|string',
            'is_paid' => 'nullable|boolean',
            'status' => 'nullable|string|in:pending,approved,rejected',
        ]);

        $user = $request->user();

        $leaveRequest = new Leave();
        $leaveRequest->company_id = 1; // Asumsi company_id selalu 1
        $leaveRequest->user_id = $user->id;
        $leaveRequest->leave_type_id = $request->leave_type_id;
        $leaveRequest->start_date = $request->start_date;
        $leaveRequest->end_date = $request->end_date;
        $leaveRequest->total_days = $request->total_days;
        $leaveRequest->is_half_day = $request->is_half_day ?? false;
        $leaveRequest->reason = $request->reason;
        $leaveRequest->is_paid = $request->is_paid ?? false;
        $leaveRequest->status = $request->status ?? 'pending';
        $leaveRequest->save();

        return response([
            'message' => 'Pengajuan cuti berhasil dibuat',
            'data' => $leaveRequest,
        ], 201);
    }
}
