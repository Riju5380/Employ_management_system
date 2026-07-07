<?php

namespace App\Http\Controllers;

use App\Services\AttendanceService;
use App\Models\BreakRecord;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Exception;

class BreakController extends Controller
{
    protected AttendanceService $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Start a break for today's active check-in.
     */
    public function startBreak(Request $request)
    {
        try {
            $break = $this->attendanceService->startBreak($request->user());

            return redirect()->back()->with('success', 'Break started successfully at ' . $break->break_start->format('H:i:s') . '.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * End today's active break.
     */
    public function endBreak(Request $request)
    {
        try {
            $break = $this->attendanceService->endBreak($request->user());

            return redirect()->back()->with('success', 'Break ended successfully at ' . $break->break_end->format('H:i:s') . '. Duration: ' . $break->duration_minutes . ' mins.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Get the active break for the logged-in user if any.
     */
    public function activeBreak()
    {
        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', now()->toDateString())
            ->first();

        $activeBreak = null;
        if ($attendance) {
            $activeBreak = BreakRecord::where('attendance_id', $attendance->id)
                ->whereNull('break_end')
                ->first();
        }

        return response()->json([
            'active_break' => $activeBreak,
        ]);
    }
}
