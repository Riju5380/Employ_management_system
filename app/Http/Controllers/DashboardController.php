<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\BreakRecord;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the main dashboard based on the user's role.
     */
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->employeeDashboard();
    }

    /**
     * Generate employee dashboard view and metrics.
     */
    public function employeeDashboard()
    {
        $user = auth()->user();
        $today = Carbon::today()->toDateString();
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        // Today's attendance status
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->with(['breaks', 'workLogs'])
            ->first();

        // Check if checked in, checked out, or currently on break
        $isCheckedIn = $todayAttendance && $todayAttendance->check_in && !$todayAttendance->check_out;
        $isCheckedOut = $todayAttendance && $todayAttendance->check_out;
        $activeBreak = null;

        if ($todayAttendance) {
            $activeBreak = BreakRecord::where('attendance_id', $todayAttendance->id)
                ->whereNull('break_end')
                ->first();
        }

        // Monthly Stats (for this month)
        $monthlyAttendances = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->get();

        $presentDays = $monthlyAttendances->whereIn('status', ['present', 'half-day'])->count();
        $totalHours = $monthlyAttendances->sum('total_hours');

        // Dynamic averages for Mockup #1 metrics
        $avgHours = round($monthlyAttendances->whereNotNull('total_hours')->avg('total_hours') ?? 0, 1);
        
        $attendanceIds = $monthlyAttendances->pluck('id');
        $avgBreakMins = round(BreakRecord::whereIn('attendance_id', $attendanceIds)->avg('duration_minutes') ?? 0);

        // Leaves taken this month (approved leaves)
        $leavesTaken = Leave::where('user_id', $user->id)
            ->where('status', 'approved')
            ->where(function ($q) use ($startOfMonth, $endOfMonth) {
                $q->whereBetween('from_date', [$startOfMonth, $endOfMonth])
                  ->orWhereBetween('to_date', [$startOfMonth, $endOfMonth]);
            })
            ->count();

        // Pending leaves count
        $pendingLeavesCount = Leave::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        // Work logs for today
        $todayWorkLogs = $todayAttendance
            ? $todayAttendance->workLogs()->orderBy('created_at', 'desc')->get()
            : collect();

        return view('dashboard', compact(
            'todayAttendance',
            'isCheckedIn',
            'isCheckedOut',
            'activeBreak',
            'presentDays',
            'totalHours',
            'avgHours',
            'avgBreakMins',
            'leavesTaken',
            'pendingLeavesCount',
            'todayWorkLogs'
        ));
    }

    /**
     * Generate admin dashboard view and metrics.
     */
    public function adminDashboard()
    {
        $today = Carbon::today()->toDateString();
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        // Today's counts
        $totalEmployees = User::where('role', 'employee')->count();

        $presentToday = Attendance::whereDate('date', $today)
            ->whereIn('status', ['present', 'half-day'])
            ->count();

        $absentToday = max(0, $totalEmployees - $presentToday);

        $onBreakToday = BreakRecord::whereNull('break_end')
            ->whereHas('attendance', function ($q) use ($today) {
                $q->whereDate('date', $today);
            })
            ->count();

        // Recent activity feed (recent check-ins, check-outs, break states)
        $recentActivity = Attendance::with('user')
            ->whereDate('date', $today)
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        // Pending Leave Requests
        $pendingLeaves = Leave::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // Dynamic averages for Mockup #2 stats
        $totalPossibleSessions = max(1, $totalEmployees * Carbon::now()->day);
        $totalPresentSessions = Attendance::whereBetween('date', [$startOfMonth, $endOfMonth])
            ->whereIn('status', ['present', 'half-day'])
            ->count();
        $avgAttendanceRate = round(($totalPresentSessions / $totalPossibleSessions) * 100, 1);
        $avgAttendanceRate = min(100.0, $avgAttendanceRate);

        // Sum Overtime (worked hours above standard 8 hours)
        $totalOvertime = Attendance::whereBetween('date', [$startOfMonth, $endOfMonth])
            ->where('total_hours', '>', 8)
            ->get()
            ->map(fn($a) => $a->total_hours - 8)
            ->sum();
        $totalOvertime = round($totalOvertime, 1);

        // Monthly Summary per employee
        $employees = User::where('role', 'employee')
            ->with(['attendances' => function ($q) use ($startOfMonth, $endOfMonth) {
                $q->whereBetween('date', [$startOfMonth, $endOfMonth]);
            }, 'leaves' => function ($q) use ($startOfMonth, $endOfMonth) {
                $q->where('status', 'approved')
                  ->where(function ($sub) use ($startOfMonth, $endOfMonth) {
                      $sub->whereBetween('from_date', [$startOfMonth, $endOfMonth])
                          ->orWhereBetween('to_date', [$startOfMonth, $endOfMonth]);
                  });
            }])
            ->get()
            ->map(function ($emp) {
                $emp->present_days = $emp->attendances->where('status', 'present')->count() + ($emp->attendances->where('status', 'half-day')->count() * 0.5);
                $emp->total_hours = $emp->attendances->sum('total_hours');
                
                // Count exact leaves (or approved records)
                $emp->leaves_count = $emp->leaves->count();
                return $emp;
            });

        return view('admin.dashboard', compact(
            'totalEmployees',
            'presentToday',
            'absentToday',
            'onBreakToday',
            'recentActivity',
            'pendingLeaves',
            'avgAttendanceRate',
            'totalOvertime',
            'employees'
        ));
    }

    /**
     * Display a list of all employees for the admin.
     */
    public function adminEmployees()
    {
        $employees = User::where('role', 'employee')->paginate(10);
        return view('admin.employees', compact('employees'));
    }
}
