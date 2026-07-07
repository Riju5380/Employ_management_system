<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeaveRequest;
use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of the user's leaves.
     */
    public function index()
    {
        $leaves = Leave::where('user_id', auth()->id())
            ->orderBy('from_date', 'desc')
            ->paginate(10);

        // Also fetch pending leaves for employees on the same page for convenience
        return view('leaves.index', compact('leaves'));
    }

    /**
     * Show the form for creating a new leave request.
     */
    public function create()
    {
        return view('leaves.create');
    }

    /**
     * Store a newly created leave request in storage.
     */
    public function store(StoreLeaveRequest $request)
    {
        Leave::create([
            'user_id' => auth()->id(),
            'leave_type' => $request->input('leave_type'),
            'from_date' => $request->input('from_date'),
            'to_date' => $request->input('to_date'),
            'reason' => $request->input('reason'),
            'status' => 'pending',
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave request submitted successfully.');
    }

    /**
     * Cancel (delete) a pending leave request.
     */
    public function destroy(Leave $leave)
    {
        if ($leave->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        if ($leave->status !== 'pending') {
            return redirect()->back()->with('error', 'Cannot cancel a leave request that has already been ' . $leave->status . '.');
        }

        $leave->delete();

        return redirect()->route('leaves.index')->with('success', 'Leave request cancelled successfully.');
    }

    /**
     * Admin action: Approve a leave request.
     */
    public function approve(Leave $leave)
    {
        // Double check admin role
        if (!auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Unauthorized. Only admins can approve leaves.');
        }

        $leave->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);

        // Optional/Good Practice: Mark attendance for the leave days as 'leave'
        // But for simplicity, we just flash a success message.
        return redirect()->back()->with('success', 'Leave request approved successfully.');
    }

    /**
     * Admin action: Reject a leave request.
     */
    public function reject(Leave $leave)
    {
        // Double check admin role
        if (!auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Unauthorized. Only admins can reject leaves.');
        }

        $leave->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Leave request rejected successfully.');
    }
}
