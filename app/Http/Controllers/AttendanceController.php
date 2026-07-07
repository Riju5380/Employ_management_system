<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckInRequest;
use App\Models\Attendance;
use App\Models\User;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Exception;

class AttendanceController extends Controller
{
    protected AttendanceService $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Handle the check-in action.
     */
    public function checkIn(CheckInRequest $request)
    {
        try {
            $attendance = $this->attendanceService->checkIn(
                $request->user(),
                $request->input('notes')
            );

            return redirect()->back()->with('success', 'Checked in successfully at ' . $attendance->check_in->format('H:i:s') . '.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Handle the check-out action.
     */
    public function checkOut(Request $request)
    {
        $request->validate([
            'work_summary' => 'nullable|string',
            'work_document' => 'nullable|file|mimes:pdf,docx,doc,png,jpg,jpeg,zip|max:10240',
        ]);

        try {
            $attendance = $this->attendanceService->checkOut(
                $request->user(),
                $request->input('work_summary'),
                $request->file('work_document')
            );

            return redirect()->back()->with('success', 'Checked out successfully at ' . $attendance->check_out->format('H:i:s') . '. Total hours: ' . $attendance->total_hours);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Return today's attendance details for the logged-in user.
     */
    public function today()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', now()->toDateString())
            ->with(['breaks', 'workLogs'])
            ->first();

        return view('attendance.today', compact('attendance'));
    }

    /**
     * Paginated list of attendance logs for Admin.
     */
    public function index(Request $request)
    {
        $query = Attendance::with(['user', 'breaks', 'workLogs']);

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->input('start_date'), $request->input('end_date')]);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $attendances = $query->orderBy('date', 'desc')
            ->orderBy('check_in', 'desc')
            ->paginate(15)
            ->withQueryString();

        $users = User::orderBy('name')->get();

        return view('admin.attendance', compact('attendances', 'users'));
    }

    /**
     * Paginated history for the logged-in employee.
     */
    public function myAttendance()
    {
        $attendances = Attendance::where('user_id', auth()->id())
            ->with(['breaks', 'workLogs'])
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('attendance.history', compact('attendances'));
    }
}
