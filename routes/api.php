<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BasicSalaryController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\DesignationController;
use App\Http\Controllers\Api\HolidayController;
use App\Http\Controllers\Api\LeaveController;
use App\Http\Controllers\Api\LeaveTypeController;
use App\Http\Controllers\Api\PayrollController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ShiftController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\UserAttendanceController;
use App\Http\Controllers\Api\UserLeaveController;
use App\Http\Controllers\Api\UserManagementController;
use App\Http\Controllers\Api\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserHasPermission;

//auth
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//department
//Route::apiResource('/departments', DepartmentController::class)->middleware('auth:sanctum');
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/departments', [DepartmentController::class, 'index'])
        ->middleware(EnsureUserHasPermission::class.':departments_view');

    Route::get('/departments/{id}', [DepartmentController::class, 'show'])
        ->middleware(EnsureUserHasPermission::class.':departments_view');

    Route::post('/departments', [DepartmentController::class, 'store'])
        ->middleware(EnsureUserHasPermission::class.':departments_add');

    Route::put('/departments/{id}', [DepartmentController::class, 'update'])
        ->middleware(EnsureUserHasPermission::class.':departments_edit');

    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])
        ->middleware(EnsureUserHasPermission::class.':departments_delete');
});

//designation
//Route::apiResource('/designations', DesignationController::class)->middleware('auth:sanctum');
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/designations', [DesignationController::class, 'index'])
        ->middleware(EnsureUserHasPermission::class.':designations_view');

    Route::get('/designations/{id}', [DesignationController::class, 'show'])
        ->middleware(EnsureUserHasPermission::class.':designations_view');

    Route::post('/designations', [DesignationController::class, 'store'])
        ->middleware(EnsureUserHasPermission::class.':designations_add');

    Route::put('/designations/{id}', [DesignationController::class, 'update'])
        ->middleware(EnsureUserHasPermission::class.':designations_edit');

    Route::delete('/designations/{id}', [DesignationController::class, 'destroy'])
        ->middleware(EnsureUserHasPermission::class.':designations_delete');
});

//shift
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/shifts', [ShiftController::class, 'index'])
        ->middleware(EnsureUserHasPermission::class.':shifts_view');

    Route::get('/shifts/{id}', [ShiftController::class, 'show'])
        ->middleware(EnsureUserHasPermission::class.':shifts_view');

    Route::post('/shifts', [ShiftController::class, 'store'])
        ->middleware(EnsureUserHasPermission::class.':shifts_add');

    Route::put('/shifts/{id}', [ShiftController::class, 'update'])
        ->middleware(EnsureUserHasPermission::class.':shifts_edit');

    Route::delete('/shifts/{id}', [ShiftController::class, 'destroy'])
        ->middleware(EnsureUserHasPermission::class.':shifts_delete');
});

//company
Route::get('/company', [CompanyController::class, 'show']);
Route::put('/company', [CompanyController::class, 'update']);

//role
Route::apiResource('/roles', UserManagementController::class)->middleware('auth:sanctum');

//basic salary
Route::apiResource('/basic-salaries', BasicSalaryController::class)->middleware('auth:sanctum');

//holiday
//Route::apiResource('/holidays', HolidayController::class)->middleware('auth:sanctum');
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/holidays', [HolidayController::class, 'index'])
        ->middleware(EnsureUserHasPermission::class.':holidays_view');

    Route::get('/holidays/{id}', [HolidayController::class, 'show'])
        ->middleware(EnsureUserHasPermission::class.':holidays_view');

    Route::post('/holidays', [HolidayController::class, 'store'])
        ->middleware(EnsureUserHasPermission::class.':holidays_add');

    Route::put('/holidays/{id}', [HolidayController::class, 'update'])
        ->middleware(EnsureUserHasPermission::class.':holidays_edit');

    Route::delete('/holidays/{id}', [HolidayController::class, 'destroy'])
        ->middleware(EnsureUserHasPermission::class.':holidays_delete');
});

//leave type
Route::apiResource('/leave-types', LeaveTypeController::class)->middleware('auth:sanctum');

//leave
// Route::apiResource('/leaves', LeaveController::class)->middleware('auth:sanctum');
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/leaves', [LeaveController::class, 'index'])
        ->middleware(EnsureUserHasPermission::class.':leaves_view');

    Route::get('/leaves/{id}', [LeaveController::class, 'show'])
        ->middleware(EnsureUserHasPermission::class.':leaves_view');

    Route::post('/leaves', [LeaveController::class, 'store'])
        ->middleware(EnsureUserHasPermission::class.':leaves_add');

    Route::put('/leaves/{id}', [LeaveController::class, 'update'])
        ->middleware(EnsureUserHasPermission::class.':leaves_edit');

    Route::delete('/leaves/{id}', [LeaveController::class, 'destroy'])
        ->middleware(EnsureUserHasPermission::class.':leaves_delete');
});
Route::apiResource('/user-leaves', UserLeaveController::class)->middleware('auth:sanctum'); //For Mobile App

//attendance
// Route::apiResource('/attendances', AttendanceController::class)->middleware('auth:sanctum');
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/attendances', [AttendanceController::class, 'index'])
        ->middleware(EnsureUserHasPermission::class.':attendance_view');

    Route::get('/attendances/{id}', [AttendanceController::class, 'show'])
        ->middleware(EnsureUserHasPermission::class.':attendance_view');

    Route::post('/attendances', [AttendanceController::class, 'store'])
        ->middleware(EnsureUserHasPermission::class.':attendance_add');

    Route::put('/attendances/{id}', [AttendanceController::class, 'update'])
        ->middleware(EnsureUserHasPermission::class.':attendance_edit');

    Route::delete('/attendances/{id}', [AttendanceController::class, 'destroy'])
        ->middleware(EnsureUserHasPermission::class.':attendance_delete');
});
Route::post('attendance/clock-in', [UserAttendanceController::class, 'clockIn'])->middleware('auth:sanctum'); //For Mobile App
Route::post('attendance/clock-out', [UserAttendanceController::class, 'clockOut'])->middleware('auth:sanctum'); //For Mobile App
Route::get('/attendance/history', [UserAttendanceController::class, 'getAttendanceHistory'])->middleware('auth:sanctum');

// route for add leave or holiday
//Route::post('attendance/apply-leave', [AttendanceController::class, 'applyLeave'])->middleware('auth:sanctum');

//warehouse
Route::apiResource('/warehouse', WarehouseController::class)->middleware('auth:sanctum');

//staff
Route::get('/staff', [StaffController::class, 'index'])->middleware('auth:sanctum');
Route::get('/staff/{id}', [StaffController::class, 'show'])->middleware('auth:sanctum');
Route::post('/staff', [StaffController::class, 'store'])->middleware('auth:sanctum');
Route::post('/staff/{id}', [StaffController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->middleware('auth:sanctum');

//payroll
Route::post('payrolls/generate', [PayrollController::class, 'generatePayroll'])
    ->name('payrolls.generate')->middleware('auth:sanctum');
Route::put('payrolls/{id}/status', [PayrollController::class, 'updatePayrollStatus'])
    ->name('payrolls.updateStatus')->middleware('auth:sanctum');
Route::get('payrolls/{id}', [PayrollController::class, 'getPayrollDetails'])
    ->name('payrolls.getPayrollDetails')->middleware('auth:sanctum');
    Route::get('payrolls', [PayrollController::class, 'index'])
    ->name('payrolls.index')->middleware('auth:sanctum');

Route::post('payrolls', [PayrollController::class, 'store'])
    ->name('payrolls.store')->middleware('auth:sanctum');

Route::get('payrolls/{id}', [PayrollController::class, 'show'])
    ->name('payrolls.show')->middleware('auth:sanctum');

Route::put('payrolls/{id}', [PayrollController::class, 'update'])
    ->name('payrolls.update')->middleware('auth:sanctum');

Route::delete('payrolls/{id}', [PayrollController::class, 'destroy'])
    ->name('payrolls.destroy')->middleware('auth:sanctum');

//dashboard
Route::get('/dashboard/today-summary', [DashboardController::class, 'getTodaySummary'])->middleware('auth:sanctum');
Route::get('/dashboard/today-attendance', [DashboardController::class, 'getAllTodayAttendance'])->middleware('auth:sanctum');
Route::get('/dashboard/pending-leave', [DashboardController::class, 'getAllPendingLeave'])->middleware('auth:sanctum');

//permission
Route::apiResource('/permissions', PermissionController::class)->middleware('auth:sanctum');

