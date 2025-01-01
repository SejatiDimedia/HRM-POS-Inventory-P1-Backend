<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAttendanceController extends Controller
{
    /**
     * Mark clock-in for the logged-in user.
     */
    public function clockIn(Request $request)
    {
        $request->validate([
            // 'company_id' => 'required|exists:companies,id',
            'date' => 'nullable|date',
        ]);

        $user = Auth::user();
        $attendance = Attendance::updateOrCreate(
            [
                'user_id' => $user->id,
                'date' => $request->date ?? today()->toDateString(),
            ],
            [
                'company_id' => 1,
                'clock_in_date_time' => now(),
                'is_holiday' => false,
                'is_leave' => false,
                'is_late' => false,
                'is_half_day' => false,
                'is_paid' => false,
                'status' => 'present',
            ]
        );

        return response([
            'message' => 'Clock-in recorded successfully',
            'data' => $attendance,
        ], 200);
    }

    /**
     * Mark clock-out for the logged-in user.
     */
    public function clockOut(Request $request)
    {
        $request->validate([
            'date' => 'nullable|date',
        ]);

        $user = Auth::user();
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $request->date ?? today()->toDateString())
            ->first();

        if (!$attendance) {
            return response([
                'message' => 'No clock-in record found for today',
            ], 404);
        }

        $attendance->clock_out_date_time = now();
        $attendance->total_duration = $attendance->clock_out_date_time->diffInMinutes($attendance->clock_in_date_time);
        $attendance->save();

        return response([
            'message' => 'Clock-out recorded successfully',
            'data' => $attendance,
        ], 200);
    }

    /**
     * Get clock-in and clock-out history for the logged-in user.
     */
    public function getAttendanceHistory(Request $request)
    {
        $user = Auth::user();

        // Optionally, you can filter by date range if needed
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $attendances = Attendance::where('user_id', $user->id)
            ->when($request->start_date, function ($query) use ($request) {
                return $query->where('date', '>=', $request->start_date);
            })
            ->when($request->end_date, function ($query) use ($request) {
                return $query->where('date', '<=', $request->end_date);
            })
            ->orderBy('date', 'desc')
            ->get();

        if ($attendances->isEmpty()) {
            return response([
                'message' => 'No attendance history found',
            ], 404);
        }

        return response([
            'message' => 'Attendance history retrieved successfully',
            'data' => $attendances,
        ], 200);
    }

    /**
     * Apply for leave or holiday for the logged-in user.
     */
    // public function applyLeave(Request $request)
    // {
    //     $request->validate([
    //         'company_id' => 'required|exists:companies,id',
    //         'date' => 'required|date',
    //         'is_holiday' => 'nullable|boolean',
    //         'is_leave' => 'nullable|boolean',
    //         'leave_id' => 'nullable|exists:leaves,id',
    //         'leave_type_id' => 'nullable|exists:leave_types,id',
    //         'holiday_id' => 'nullable|exists:holidays,id',
    //         'reason' => 'required|string',
    //     ]);

    //     $user = Auth::user();
    //     $attendance = Attendance::updateOrCreate(
    //         [
    //             'user_id' => $user->id,
    //             'date' => $request->date,
    //         ],
    //         [
    //             'company_id' => $request->company_id,
    //             'is_holiday' => $request->is_holiday ?? false,
    //             'is_leave' => $request->is_leave ?? false,
    //             'leave_id' => $request->leave_id,
    //             'leave_type_id' => $request->leave_type_id,
    //             'holiday_id' => $request->holiday_id,
    //             'status' => 'pending',
    //             'reason' => $request->reason,
    //         ]
    //     );

    //     return response([
    //         'message' => 'Leave or holiday application submitted successfully',
    //         'data' => $attendance,
    //     ], 201);
    // }
}
