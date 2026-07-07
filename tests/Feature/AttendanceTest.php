<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Attendance;
use App\Models\BreakRecord;
use App\Models\Leave;
use App\Services\AttendanceService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    protected AttendanceService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AttendanceService();
    }

    /**
     * Test 1: Standard Employee Check-In.
     */
    public function test_employee_can_check_in(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);

        $attendance = $this->service->checkIn($employee, 'Test checkin notes');

        $this->assertDatabaseHas('attendances', [
            'user_id' => $employee->id,
            'status' => 'present',
            'notes' => 'Test checkin notes',
        ]);
        
        $this->assertEquals(Carbon::today()->toDateString(), $attendance->date->toDateString());
        $this->assertNotNull($attendance->check_in);
        $this->assertNull($attendance->check_out);
    }

    /**
     * Test 2: Double Check-in Prevention.
     */
    public function test_employee_cannot_check_in_twice_on_same_day(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);

        $this->service->checkIn($employee);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('You have already checked in for today.');

        $this->service->checkIn($employee);
    }

    /**
     * Test 3: Starting and Ending Breaks.
     */
    public function test_employee_can_start_and_end_breaks(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $this->service->checkIn($employee);

        Carbon::setTestNow(now()->subMinutes(30));
        $break = $this->service->startBreak($employee);
        
        $this->assertDatabaseHas('breaks', [
            'attendance_id' => $break->attendance_id,
            'break_end' => null,
            'duration_minutes' => null,
        ]);

        Carbon::setTestNow(null); // Reset time to now
        $endedBreak = $this->service->endBreak($employee);

        $this->assertNotNull($endedBreak->break_end);
        $this->assertEquals(30, $endedBreak->duration_minutes);
    }

    /**
     * Test 4: Cannot start a break without checking in.
     */
    public function test_employee_cannot_start_break_without_check_in(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Cannot start a break. You must have an active check-in first.');

        $this->service->startBreak($employee);
    }

    /**
     * Test 5: Cannot start two active breaks simultaneously.
     */
    public function test_employee_cannot_start_multiple_active_breaks(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $this->service->checkIn($employee);

        $this->service->startBreak($employee);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('You already have an active break.');

        $this->service->startBreak($employee);
    }

    /**
     * Test 6: Check-out auto-ends active break and computes net working hours correctly.
     */
    public function test_checkout_auto_ends_breaks_and_calculates_working_hours(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);

        // Set check-in to 8 hours ago
        Carbon::setTestNow(now()->subHours(8));
        $this->service->checkIn($employee);

        // Start break 6 hours ago
        Carbon::setTestNow(now()->addHours(2));
        $this->service->startBreak($employee);

        // Reset to real now (total shift time = 8 hours, active break has been running for 6 hours)
        Carbon::setTestNow(null);
        $attendance = $this->service->checkOut($employee, 'Completed the API integration work and tested components.');

        // The running break should be auto-ended
        $this->assertDatabaseMissing('breaks', [
            'attendance_id' => $attendance->id,
            'break_end' => null,
        ]);

        // Net working hours = 8 hours total shift - 6 hours break = 2.00 hours
        $this->assertEquals(2.00, $attendance->total_hours);
        $this->assertEquals('Completed the API integration work and tested components.', $attendance->work_summary);
    }

    /**
     * Test 9: Employee Cannot Check-Out Without Submitting Today's Work.
     */
    public function test_employee_cannot_checkout_without_work_summary(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $this->service->checkIn($employee);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("You must submit today's work summary or upload a work document to check out.");

        $this->service->checkOut($employee);
    }

    /**
     * Test 7: Admin Role access control.
     */
    public function test_employee_cannot_access_admin_endpoints(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);

        $response = $this->actingAs($employee)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    /**
     * Test 8: Admin can approve and reject leave applications.
     */
    public function test_admin_can_approve_leaves(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $admin = User::factory()->create(['role' => 'admin']);

        $leave = Leave::create([
            'user_id' => $employee->id,
            'leave_type' => 'sick',
            'from_date' => Carbon::tomorrow()->toDateString(),
            'to_date' => Carbon::tomorrow()->addDay()->toDateString(),
            'reason' => 'Feeling sick',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.leaves.approve', $leave));

        $response->assertRedirect();
        
        $this->assertDatabaseHas('leaves', [
            'id' => $leave->id,
            'status' => 'approved',
            'approved_by' => $admin->id,
        ]);
    }
}
