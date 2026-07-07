<?php

namespace App\Services;

use App\Models\User;
use App\Models\Attendance;
use App\Models\BreakRecord;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    /**
     * Check in the user for today.
     *
     * @param User $user
     * @param string|null $notes
     * @return Attendance
     * @throws Exception
     */
    public function checkIn(User $user, ?string $notes = null): Attendance
    {
        $today = Carbon::today();

        // Rule: Cannot check in twice on the same day
        $existing = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if ($existing) {
            throw new Exception('You have already checked in for today.');
        }

        return Attendance::create([
            'user_id' => $user->id,
            'date' => $today->toDateString(),
            'check_in' => Carbon::now(),
            'status' => 'present',
            'notes' => $notes,
        ]);
    }

    /**
     * Check out the user for today.
     *
     * @param User $user
     * @param string|null $workSummary
     * @param \Illuminate\Http\UploadedFile|null $workDocument
     * @return Attendance
     * @throws Exception
     */
    public function checkOut(User $user, ?string $workSummary = null, ?\Illuminate\Http\UploadedFile $workDocument = null): Attendance
    {
        $today = Carbon::today();

        // Find today's attendance
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance) {
            throw new Exception('No active check-in found for today.');
        }

        if ($attendance->check_out) {
            throw new Exception('You have already checked out for today.');
        }

        // Enforce today's work check: summary or document must be present
        if (empty($workSummary) && !$workDocument) {
            throw new Exception("You must submit today's work summary or upload a work document to check out.");
        }

        // Process document upload if any
        $documentPath = null;
        if ($workDocument) {
            $documentPath = $workDocument->store('work_documents', 'public');
        }

        return DB::transaction(function () use ($attendance, $workSummary, $documentPath) {
            $now = Carbon::now();

            // Rule: Check-out auto-ends any active break
            $activeBreak = BreakRecord::where('attendance_id', $attendance->id)
                ->whereNull('break_end')
                ->first();

            if ($activeBreak) {
                $activeBreak->update([
                    'break_end' => $now,
                    'duration_minutes' => max(0, $activeBreak->break_start->diffInMinutes($now)),
                ]);
            }

            // Refresh relation to get updated break records if any
            $attendance->load('breaks');

            // Calculate total hours
            // total_hours = (check_out - check_in) - total break minutes
            $totalMinutes = $attendance->check_in->diffInMinutes($now);
            $breakMinutes = $attendance->totalBreakMinutes();
            $netMinutes = max(0, $totalMinutes - $breakMinutes);

            // Convert to decimal hours, e.g. 8.5 for 8 hours 30 mins
            $totalHours = round($netMinutes / 60, 2);

            $attendance->update([
                'check_out' => $now,
                'total_hours' => $totalHours,
                'work_summary' => $workSummary,
                'work_document' => $documentPath,
            ]);

            return $attendance;
        });
    }

    /**
     * Start a break for the user.
     *
     * @param User $user
     * @return BreakRecord
     * @throws Exception
     */
    public function startBreak(User $user): BreakRecord
    {
        $today = Carbon::today();

        // Rule: Cannot start a break without checking in first
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance || !$attendance->check_in || $attendance->check_out) {
            throw new Exception('Cannot start a break. You must have an active check-in first.');
        }

        // Rule: Cannot have two active breaks simultaneously
        $activeBreak = BreakRecord::where('attendance_id', $attendance->id)
            ->whereNull('break_end')
            ->first();

        if ($activeBreak) {
            throw new Exception('You already have an active break.');
        }

        return BreakRecord::create([
            'attendance_id' => $attendance->id,
            'break_start' => Carbon::now(),
        ]);
    }

    /**
     * End the current active break.
     *
     * @param User $user
     * @return BreakRecord
     * @throws Exception
     */
    public function endBreak(User $user): BreakRecord
    {
        $today = Carbon::today();

        // Find today's attendance
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance) {
            throw new Exception('Cannot end break. No active check-in found for today.');
        }

        // Find active break
        $activeBreak = BreakRecord::where('attendance_id', $attendance->id)
            ->whereNull('break_end')
            ->first();

        if (!$activeBreak) {
            throw new Exception('No active break found.');
        }

        $now = Carbon::now();
        $duration = max(0, $activeBreak->break_start->diffInMinutes($now));

        $activeBreak->update([
            'break_end' => $now,
            'duration_minutes' => $duration,
        ]);

        return $activeBreak;
    }
}
