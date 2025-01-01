<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('user')->get();

        return response([
            'message' => 'Attendances retrieved successfully',
            'data' => $attendances,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'nullable|date',
            'is_holiday' => 'nullable|boolean',
            'is_leave' => 'nullable|boolean',
            'user_id' => 'required|exists:users,id',
            'leave_id' => 'nullable|exists:leaves,id',
            'leave_type_id' => 'nullable|exists:leave_types,id',
            'holiday_id' => 'nullable|exists:holidays,id',
            'clock_in_date_time' => 'nullable|date_format:Y-m-d H:i:s',
            'clock_out_date_time' => 'nullable|date_format:Y-m-d H:i:s',
            'total_duration' => 'nullable|integer',
            'is_late' => 'nullable|boolean',
            'is_half_day' => 'nullable|boolean',
            'is_paid' => 'nullable|boolean',
            'status' => 'nullable|string',
            'reason' => 'nullable|string',
        ]);

        $attendance = new Attendance();
        $attendance->company_id = 1;
        $attendance->date = $request->date;
        $attendance->is_holiday = $request->is_holiday ?? false;
        $attendance->is_leave = $request->is_leave ?? false;
        $attendance->user_id = $request->user_id;
        $attendance->leave_id = $request->leave_id;
        $attendance->leave_type_id = $request->leave_type_id;
        $attendance->holiday_id = $request->holiday_id;
        $attendance->clock_in_date_time = $request->clock_in_date_time;
        $attendance->clock_out_date_time = $request->clock_out_date_time;
        $attendance->total_duration = $request->total_duration;
        $attendance->is_late = $request->is_late ?? false;
        $attendance->is_half_day = $request->is_half_day ?? false;
        $attendance->is_paid = $request->is_paid ?? false;
        $attendance->status = $request->status ?? 'present';
        $attendance->reason = $request->reason;
        $attendance->save();

        return response([
            'message' => 'Attendance record created successfully',
            'data' => $attendance,
        ], 201);
    }

    public function show(string $id)
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return response([
                'message' => 'Attendance record not found',
            ], 404);
        }

        return response([
            'message' => 'Attendance record retrieved successfully',
            'data' => $attendance,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'date' => 'nullable|date',
            'is_holiday' => 'nullable|boolean',
            'is_leave' => 'nullable|boolean',
            'user_id' => 'required|exists:users,id',
            'leave_id' => 'nullable|exists:leaves,id',
            'leave_type_id' => 'nullable|exists:leave_types,id',
            'holiday_id' => 'nullable|exists:holidays,id',
            'clock_in_date_time' => 'nullable|date_format:Y-m-d H:i:s',
            'clock_out_date_time' => 'nullable|date_format:Y-m-d H:i:s',
            'total_duration' => 'nullable|integer',
            'is_late' => 'nullable|boolean',
            'is_half_day' => 'nullable|boolean',
            'is_paid' => 'nullable|boolean',
            'status' => 'nullable|string',
            'reason' => 'nullable|string',
        ]);

        $attendance = Attendance::find($id);

        if (!$attendance) {
            return response([
                'message' => 'Attendance record not found',
            ], 404);
        }

        $attendance->company_id = 1;
        $attendance->date = $request->date;
        $attendance->is_holiday = $request->is_holiday ?? false;
        $attendance->is_leave = $request->is_leave ?? false;
        $attendance->user_id = $request->user_id;
        $attendance->leave_id = $request->leave_id;
        $attendance->leave_type_id = $request->leave_type_id;
        $attendance->holiday_id = $request->holiday_id;
        $attendance->clock_in_date_time = $request->clock_in_date_time;
        $attendance->clock_out_date_time = $request->clock_out_date_time;
        $attendance->total_duration = $request->total_duration;
        $attendance->is_late = $request->is_late ?? false;
        $attendance->is_half_day = $request->is_half_day ?? false;
        $attendance->is_paid = $request->is_paid ?? false;
        $attendance->status = $request->status ?? 'present';
        $attendance->reason = $request->reason;
        $attendance->save();

        return response([
            'message' => 'Attendance record updated successfully',
            'data' => $attendance,
        ], 200);
    }

    public function destroy(string $id)
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return response([
                'message' => 'Attendance record not found',
            ], 404);
        }

        $attendance->delete();

        return response([
            'message' => 'Attendance record deleted successfully',
        ], 200);
    }
}
