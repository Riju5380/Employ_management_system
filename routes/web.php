<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BreakController;
use App\Http\Controllers\WorkLogController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Shared Dashboard route (delegates dynamically based on role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management (Laravel Breeze standard)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Attendance & Break Operations
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.check-in');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.check-out');
    Route::post('/attendance/break/start', [BreakController::class, 'startBreak'])->name('attendance.break.start');
    Route::post('/attendance/break/end', [BreakController::class, 'endBreak'])->name('attendance.break.end');
    Route::get('/attendance/today', [AttendanceController::class, 'today'])->name('attendance.today');
    Route::get('/attendance/my-history', [AttendanceController::class, 'myAttendance'])->name('attendance.my-history');

    // Resource Routes
    Route::resource('work-logs', WorkLogController::class)->except(['show', 'create']);
    Route::resource('leaves', LeaveController::class)->except(['show']);

    // Admin-only Routes (restricted by EnsureRole middleware)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/admin/attendance', [AttendanceController::class, 'index'])->name('admin.attendance');
        Route::get('/admin/employees', [DashboardController::class, 'adminEmployees'])->name('admin.employees');
        Route::get('/admin/employees/create', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'createEmployee'])->name('admin.employees.create');
        Route::post('/admin/employees/store', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'storeEmployee'])->name('admin.employees.store');
        Route::post('/admin/leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('admin.leaves.approve');
        Route::post('/admin/leaves/{leave}/reject', [LeaveController::class, 'reject'])->name('admin.leaves.reject');
    });
});

require __DIR__.'/auth.php';
