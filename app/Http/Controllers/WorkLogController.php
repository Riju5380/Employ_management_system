<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkLogRequest;
use App\Http\Requests\UpdateWorkLogRequest;
use App\Models\Attendance;
use App\Models\WorkLog;
use Illuminate\Http\Request;

class WorkLogController extends Controller
{
    /**
     * Display a listing of work logs scoped by date.
     */
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        
        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', $date)
            ->first();

        $workLogs = $attendance 
            ? WorkLog::where('attendance_id', $attendance->id)->orderBy('created_at', 'desc')->get()
            : collect();

        return view('work-logs.index', compact('workLogs', 'date', 'attendance'));
    }

    /**
     * Store a newly created work log.
     */
    public function store(StoreWorkLogRequest $request)
    {
        // Business Rule: Work logs are tied to an attendance record (must be checked in today)
        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', now()->toDateString())
            ->first();

        if (!$attendance || !$attendance->check_in) {
            return redirect()->back()->with('error', 'Cannot add work log. You must check in first today.');
        }

        if ($attendance->check_out) {
            return redirect()->back()->with('error', 'Cannot add work log. You have already checked out for today.');
        }

        WorkLog::create([
            'attendance_id' => $attendance->id,
            'user_id' => auth()->id(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category' => $request->input('category'),
            'duration_minutes' => $request->input('duration_minutes'),
        ]);

        return redirect()->back()->with('success', 'Work log added successfully.');
    }

    /**
     * Update the specified work log.
     */
    public function update(UpdateWorkLogRequest $request, WorkLog $workLog)
    {
        if ($workLog->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Optional check: ensure they can only edit today's logs or if attendance isn't checked out
        $attendance = $workLog->attendance;
        if ($attendance && $attendance->check_out) {
            // But let's allow updating logs even after checkout if they make a mistake, or we can enforce it.
            // Let's enforce that they can only edit if they are checked in or it's today's log.
            if ($attendance->date->toDateString() !== now()->toDateString()) {
                return redirect()->back()->with('error', 'Cannot edit work logs from previous days.');
            }
        }

        $workLog->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category' => $request->input('category'),
            'duration_minutes' => $request->input('duration_minutes'),
        ]);

        return redirect()->back()->with('success', 'Work log updated successfully.');
    }

    /**
     * Remove the specified work log.
     */
    public function destroy(WorkLog $workLog)
    {
        if ($workLog->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $attendance = $workLog->attendance;
        if ($attendance && $attendance->date->toDateString() !== now()->toDateString()) {
            return redirect()->back()->with('error', 'Cannot delete work logs from previous days.');
        }

        $workLog->delete();

        return redirect()->back()->with('success', 'Work log deleted successfully.');
    }
}
