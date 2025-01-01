<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function getTodaySummary()
    {
        $today = Carbon::today()->toDateString();
        $companyId = 1;

        $totalPresent = Attendance::where('date', $today)
            ->where('company_id', $companyId)
            ->where('status', 'present')
            ->count();

        $totalLeave = Leave::where('company_id', $companyId)
            ->where('status', 'approved')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->count();

        $totalNotMarked = Attendance::where('date', $today)
            ->where('company_id', $companyId)
            ->where('status', 'not_marked')
            ->count();

        $totalAbsent = Attendance::where('date', $today)
            ->where('company_id', $companyId)
            ->where('status', 'absent')
            ->count();

        return response()->json([
            'message' => 'Today summary successfully',
            'data' => [
                'total_present' => $totalPresent,
                'total_leave' => $totalLeave,
                'total_not_marked' => $totalNotMarked,
                'total_absent' => $totalAbsent,
            ],
        ], 200);
    }


    public function getAllTodayAttendance()
    {
        $today = Carbon::today()->toDateString();
        $companyId = 1;

        $attendanceList = Attendance::where('date', $today)
            ->where('company_id', $companyId)
            ->with('user:id,name,profile_image')
            ->get();

            $attendanceData = $attendanceList->map(function ($attendance) {
                return [
                    'id' => $attendance->id,
                    'user_name' => $attendance->user->name,
                    'date' => $attendance->date,
                    // 'is_holiday' => $attendance->is_holiday,
                    // 'is_leave' => $attendance->is_leave,
                    'clock_in_date_time' => $attendance->clock_in_date_time,
                    'clock_out_date_time' => $attendance->clock_out_date_time,
                    // 'total_duration' => $attendance->total_duration,
                    'status' => $attendance->status,
                    'image' => $attendance->user->profile_image,
                ];
            });

        return response()->json([
            'message' => 'Today attendance list successfully',
            'data' => $attendanceData,
        ], 200);
    }


    public function getAllPendingLeave()
    {
        $companyId = 1;

        $pendingLeaves = Leave::where('company_id', $companyId)
            ->where('status', 'pending')
            ->with('user:id,name,profile_image', 'leaveType:id,name')
            ->get();

        $leaveData = $pendingLeaves->map(function ($leave) {
            return [
                'id' => $leave->id,
                'company_id' => $leave->company_id,
                'user_id' => $leave->user_id,
                'user_name' => $leave->user->name,
                'user_photo' => $leave->user->profile_image,
                'leave_type_id' => $leave->leave_type_id,
                'leave_type_name' => $leave->leaveType->name,
                'start_date' => $leave->start_date,
                'end_date' => $leave->end_date,
                'total_days' => $leave->total_days,
                'is_half_day' => $leave->is_half_day,
                'reason' => $leave->reason,
                'is_paid' => $leave->is_paid,
                'status' => $leave->status,
                'created_at' => $leave->created_at,
                'updated_at' => $leave->updated_at,
            ];
        });

       return response()->json([
            'message' => 'Pending leave list successfully',
            'data' => $leaveData,
        ], 200);
    }
}
