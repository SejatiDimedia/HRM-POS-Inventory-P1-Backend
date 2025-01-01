<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{

    public function generatePayroll(Request $request)
    {
        // Dapatkan bulan dan tahun dari request
        $month = $request->input('month');
        $year = $request->input('year');

        // Dapatkan semua user yang memiliki attendance pada bulan dan tahun tertentu
        $usersWithAttendance = Attendance::with('user.basicSalary')
        ->whereMonth('date', $month)
        ->whereYear('date', $year)
        ->get()
        ->groupBy('user_id');

        // Jika tidak ada pengguna yang memiliki attendance, kembalikan pesan
        if ($usersWithAttendance->isEmpty()) {
            return response()->json(['message' => 'No users found with attendance data for the selected month and year.'], 404);
        }

        $payrolls = [];

        foreach ($usersWithAttendance as $user_id => $attendanceData) {
            $leaveData = Leave::where('user_id', $user_id)
                ->whereMonth('start_date', $month)
                ->whereYear('start_date', $year)
                ->get();

            // Hitung total hari dalam sebulan
            $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            // Kalkulasi hari kerja, kehadiran, keterlambatan, dll.
            $workingDays = $attendanceData->where('is_holiday', false)->count();
            $presentDays = $attendanceData->where('status', 'present')->count();
            $halfDays = $attendanceData->where('is_half_day', true)->count();
            $lateDays = $attendanceData->where('is_late', true)->count();
            $paidLeaves = $leaveData->where('is_paid', true)->sum('total_days');
            $unpaidLeaves = $leaveData->where('is_paid', false)->sum('total_days');
            $holidayCount = $attendanceData->where('is_holiday', true)->count();

            // Cek apakah ada data attendance dan basic salary
            $firstAttendance = $attendanceData->first();

            if (!$firstAttendance || !$firstAttendance->user || !$firstAttendance->user->basicSalary) {
                continue; // Lewatkan user ini jika tidak ada data yang diperlukan
            }

            // Basic salary dari model BasicSalary
            $basicSalary = $firstAttendance->user->basicSalary->basic_salary;

            // Hitung net salary
            $salaryAmount = $basicSalary * ($presentDays + $paidLeaves) / $workingDays;
            $netSalary = $salaryAmount - ($basicSalary / $workingDays * $unpaidLeaves);

            // Set tanggal pembayaran otomatis pada tanggal 30 bulan tersebut
            $paymentDate = Carbon::createFromDate($year, $month, 30)->format('Y-m-d');

            // Simpan data payroll
            $payroll = Payroll::create([
                'company_id' => Auth::user()->company_id,
                'user_id' => $user_id,
                'month' => $month,
                'year' => $year,
                'basic_salary' => $basicSalary,
                'salary_amount' => $salaryAmount,
                'net_salary' => $netSalary,
                'total_days' => $totalDays,
                'working_days' => $workingDays,
                'present_days' => $presentDays,
                'total_office_time' => $attendanceData->sum('total_duration'),
                'total_worked_time' => $attendanceData->sum('total_worked_time'),
                'half_days' => $halfDays,
                'late_days' => $lateDays,
                'paid_leaves' => $paidLeaves,
                'unpaid_leaves' => $unpaidLeaves,
                'holiday_count' => $holidayCount,
                'payment_date' => $paymentDate,
                'status' => 'generated',
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            $payrolls[] = $payroll;
        }

        return response()->json(['message' => 'Payroll generated successfully', 'payrolls' => $payrolls], 201);
    }


    public function updatePayrollStatus(Request $request, $id)
    {
        $payroll = Payroll::findOrFail($id);

        $payroll->update([
            'status' => 'paid',
            'payment_date' => now(),
            'updated_by' => Auth::id(),
        ]);

        return response()->json(['message' => 'Payroll status updated successfully'], 200);
    }

    public function getPayrollDetails($id)
    {
        $payroll = Payroll::with(['user', 'createdBy', 'updatedBy'])->findOrFail($id);

        return response()->json(['payroll' => $payroll], 200);
    }

    //index
    public function index(Request $request)
    {
        $payrolls = Payroll::with('user')
        ->when($request->input('user_name'), function ($query, $user_name) {
            // Filter by name
            return $query->whereHas('user', function ($query) use ($user_name) {
                $query->where('name', 'like', '%' . $user_name . '%');
            });
        })
        ->when($request->input('month'), function ($query, $month) {
            // Filter bby month
            return $query->where('month', $month);
        })
        ->when($request->input('year'), function ($query, $year) {
            // Filter by year
            return $query->where('year', $year);
        })
        ->orderBy('id', 'desc')
        ->get();

        return response([
            'message' => 'Successfully retrieved payroll',
            'payroll' => $payrolls,
        ], 200);
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'salary' => 'required',
            'month' => 'required',
            'year' => 'required',
            'status' => 'required',
        ]);

        $payroll = new Payroll();
        $payroll->company_id = 1;
        $payroll->user_id = $request->user_id;
        $payroll->salary = $request->salary;
        $payroll->month = $request->month;
        $payroll->year = $request->year;
        $payroll->status = $request->status;
        $payroll->save();
        return response([
            'message' => 'Payroll created successfully',
            'payroll' => $payroll,
        ], 201);
    }

    //show
    public function show($id)
    {
        $payroll = Payroll::with(['user'])->findOrFail($id);
        if (!$payroll) {
            return response([
                'message' => 'Payroll not found',
            ], 404);
        }

        return response([
            'message' => 'Successfully retrieved payroll',
            'payroll' => $payroll,
        ], 200);
    }

    //update
    public function update(Request $request, $id)
    {
        $payroll = Payroll::find($id);
        if (!$payroll) {
            return response([
                'message' => 'Payroll not found',
            ], 404);
        }

        $request->validate([
            'user_id' => 'required',
            'salary' => 'required',
            'month' => 'required',
            'year' => 'required',
            'status' => 'required',
        ]);

        $payroll->user_id = $request->user_id;
        $payroll->salary = $request->salary;
        $payroll->month = $request->month;
        $payroll->year = $request->year;
        $payroll->status = $request->status;
        $payroll->save();
        return response([
            'message' => 'Payroll updated successfully',
            'payroll' => $payroll,
        ], 200);
    }

    //destroy
    public function destroy($id)
    {
        $payroll = Payroll::find($id);
        if (!$payroll) {
            return response([
                'message' => 'Payroll not found',
            ], 404);
        }

        $payroll->delete();
        return response([
            'message' => 'Payroll deleted successfully',
        ], 200);
    }
}


// public function generatePayroll(Request $request)
    // {
    //     // Dapatkan data attendance dan leave dari user tertentu
    //     $user_id = $request->input('user_id');
    //     $month = $request->input('month');
    //     $year = $request->input('year');

    //     $attendanceData = Attendance::with('user.basicSalary')
    //         ->where('user_id', $user_id)
    //         ->whereMonth('date', $month)
    //         ->whereYear('date', $year)
    //         ->get();

    //     $leaveData = Leave::where('user_id', $user_id)
    //         ->whereMonth('start_date', $month)
    //         ->whereYear('start_date', $year)
    //         ->get();

    //     // Hitung total hari dalam sebulan
    //     $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    //     // Kalkulasi hari kerja, kehadiran, keterlambatan, dll.
    //     $workingDays = $attendanceData->where('is_holiday', false)->count();
    //     $presentDays = $attendanceData->where('status', 'present')->count();
    //     $halfDays = $attendanceData->where('is_half_day', true)->count();
    //     $lateDays = $attendanceData->where('is_late', true)->count();
    //     $paidLeaves = $leaveData->where('is_paid', true)->sum('total_days');
    //     $unpaidLeaves = $leaveData->where('is_paid', false)->sum('total_days');
    //     $holidayCount = $attendanceData->where('is_holiday', true)->count();

    //     // Cek apakah ada data attendance
    //     $firstAttendance = $attendanceData->first();

    //     if (!$firstAttendance || !$firstAttendance->user || !$firstAttendance->user->basicSalary) {
    //         return response()->json(['message' => 'User or basic salary data is missing.'], 404);
    //     }

    //     // Basic salary dari model BasicSalary (asumsi data ini sudah ada)
    //     $basicSalary = $attendanceData->first()->user->basicSalary->basic_salary;

    //     // Hitung net salary
    //     $salaryAmount = $basicSalary * ($presentDays + $paidLeaves) / $workingDays;
    //     $netSalary = $salaryAmount - ($basicSalary / $workingDays * $unpaidLeaves);

    //     // Set tanggal pembayaran otomatis pada tanggal 30 bulan tersebut
    //     $paymentDate = Carbon::createFromDate($year, $month, 30)->format('Y-m-d');

    //     // Simpan data payroll
    //     $payroll = Payroll::create([
    //         'company_id' => Auth::user()->company_id,
    //         'user_id' => $user_id,
    //         'month' => $month,
    //         'year' => $year,
    //         'basic_salary' => $basicSalary,
    //         'salary_amount' => $salaryAmount,
    //         'net_salary' => $netSalary,
    //         'total_days' => $totalDays,
    //         'working_days' => $workingDays,
    //         'present_days' => $presentDays,
    //         'total_office_time' => $attendanceData->sum('total_duration'),
    //         'total_worked_time' => $attendanceData->sum('total_worked_time'),
    //         'half_days' => $halfDays,
    //         'late_days' => $lateDays,
    //         'paid_leaves' => $paidLeaves,
    //         'unpaid_leaves' => $unpaidLeaves,
    //         'holiday_count' => $holidayCount,
    //         'payment_date' => $paymentDate,
    //         'status' => 'generated',
    //         'created_by' => Auth::id(),
    //         'updated_by' => Auth::id(),
    //     ]);

    //     return response()->json(['message' => 'Payroll generated successfully', 'payroll' => $payroll], 201);
    // }
