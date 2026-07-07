<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6 text-slate-100 pb-12">

        <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl">
            <div>
                <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">Time Off</span>
                <h1 class="text-2xl font-black text-white mt-1 tracking-tight">Leave Center</h1>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Apply for Leave Form -->
            <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl lg:col-span-1">
                <h2 class="text-md font-extrabold text-white mb-6">Apply for Leave</h2>

                <form action="{{ route('leaves.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="leave_type" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">Leave Type</label>
                        <select name="leave_type" id="leave_type" required class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none px-4 py-3 transition duration-150">
                            <option value="sick">Sick Leave</option>
                            <option value="casual">Casual Leave</option>
                            <option value="annual">Annual Leave</option>
                            <option value="unpaid">Unpaid Leave</option>
                        </select>
                    </div>

                    <div>
                        <label for="from_date" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">From Date</label>
                        <input type="date" name="from_date" id="from_date" required class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none p-3 transition duration-150">
                    </div>

                    <div>
                        <label for="to_date" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">To Date</label>
                        <input type="date" name="to_date" id="to_date" required class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none p-3 transition duration-150">
                    </div>

                    <div>
                        <label for="reason" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">Reason for Leave</label>
                        <textarea name="reason" id="reason" rows="4" required placeholder="Please describe the reason for your leave request..."
                            class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white placeholder-slate-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none p-3.5 transition duration-150"></textarea>
                    </div>

                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition duration-150 shadow shadow-indigo-600/15">
                        Submit Request
                    </button>
                </form>
            </div>

            <!-- My Requests History -->
            <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl lg:col-span-2">
                <h2 class="text-md font-extrabold text-white mb-6 flex justify-between items-center">
                    <span>My Leave History</span>
                    <span class="text-xs bg-slate-800 text-slate-400 font-semibold px-2.5 py-1 rounded-full border border-slate-700/30">{{ $leaves->total() }} Applications</span>
                </h2>

                @if($leaves->isEmpty())
                    <div class="text-center py-16 text-slate-500">
                        <svg class="h-12 w-12 mx-auto mb-3 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm font-semibold">You have not submitted any leave requests yet.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-slate-300 text-sm">
                            <thead>
                                <tr class="text-left text-xxs font-bold text-slate-500 uppercase tracking-widest border-b border-[#1f222e]">
                                    <th class="px-4 py-3">Dates</th>
                                    <th class="px-4 py-3">Type</th>
                                    <th class="px-4 py-3">Reason</th>
                                    <th class="px-4 py-3 text-center">Status</th>
                                    <th class="px-4 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#1f222e]/45">
                                @foreach($leaves as $leave)
                                    <tr class="hover:bg-white/5 transition duration-150">
                                        <td class="px-4 py-3 font-bold text-white text-xs">
                                            {{ $leave->from_date->format('M j, Y') }}
                                            <p class="text-3xs text-slate-500 font-semibold uppercase mt-0.5">to {{ $leave->to_date->format('M j, Y') }}</p>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-4xs font-bold uppercase tracking-widest bg-indigo-500/10 text-indigo-400 border border-indigo-500/15">
                                                {{ ucfirst($leave->leave_type) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 max-w-xxs truncate text-slate-400 text-xs" title="{{ $leave->reason }}">{{ $leave->reason }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-4xs font-bold uppercase tracking-widest
                                                @if($leave->status === 'approved') bg-emerald-500/10 text-emerald-400 border border-emerald-500/15
                                                @elseif($leave->status === 'rejected') bg-rose-500/10 text-rose-400 border border-rose-500/15
                                                @else bg-amber-500/10 text-amber-400 border border-amber-500/15 @endif">
                                                {{ ucfirst($leave->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            @if($leave->status === 'pending')
                                                <form action="{{ route('leaves.destroy', $leave) }}" method="POST" onsubmit="return confirm('Cancel this leave application?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-500 hover:text-rose-400 font-bold text-xxs tracking-wider uppercase">Cancel</button>
                                                </form>
                                            @else
                                                <span class="text-3xs text-slate-600 font-bold uppercase">Locked</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $leaves->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
