<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6 text-slate-100 pb-12">
        
        <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl">
            <div>
                <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">Audit Dashboard</span>
                <h1 class="text-2xl font-black text-white mt-1 tracking-tight">Attendance Audit Logs</h1>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl">
            <form method="GET" action="{{ route('admin.attendance') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="user_id" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">Employee</label>
                    <select name="user_id" id="user_id" class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none p-3 transition duration-150">
                        <option value="">All Employees</option>
                        @foreach($users as $user)
                            @if($user->isEmployee())
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">Status</label>
                    <select name="status" id="status" class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none p-3 transition duration-150">
                        <option value="">All Statuses</option>
                        <option value="present" {{ request('status') === 'present' ? 'selected' : '' }}>Present</option>
                        <option value="absent" {{ request('status') === 'absent' ? 'selected' : '' }}>Absent</option>
                        <option value="half-day" {{ request('status') === 'half-day' ? 'selected' : '' }}>Half-Day</option>
                        <option value="leave" {{ request('status') === 'leave' ? 'selected' : '' }}>On Leave</option>
                    </select>
                </div>

                <div>
                    <label for="start_date" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none p-3 transition duration-150">
                </div>

                <div>
                    <label for="end_date" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none p-3 transition duration-150">
                </div>

                <div class="md:col-span-4 flex justify-end space-x-2 pt-2">
                    <a href="{{ route('admin.attendance') }}" class="px-4 py-2 bg-[#1d1f27] hover:bg-[#252834] text-slate-300 font-semibold rounded-xl text-xs border border-[#2e3347] transition duration-150">Reset Filters</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-xs transition duration-150">Apply Filters</button>
                </div>
            </form>
        </div>

        <!-- Attendance Data Table -->
        <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl">
            @if($attendances->isEmpty())
                <div class="text-center py-12 text-slate-500">
                    <svg class="h-12 w-12 mx-auto mb-3 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-sm font-semibold">No attendance records found matching your filters.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-slate-300 text-sm">
                        <thead>
                            <tr class="text-left text-xxs font-bold text-slate-500 uppercase tracking-widest border-b border-[#1f222e]">
                                <th class="px-6 py-3">Date</th>
                                <th class="px-6 py-3">Employee</th>
                                <th class="px-6 py-3">Check-in</th>
                                <th class="px-6 py-3">Check-out</th>
                                <th class="px-6 py-3 text-center">Breaks</th>
                                <th class="px-6 py-3 text-center">Net Working Hours</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3">Work Summary / Document</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#1f222e]/45">
                            @foreach($attendances as $att)
                                <tr class="hover:bg-white/5 transition duration-150">
                                    <td class="px-6 py-4 font-bold text-white text-xs">{{ $att->date->format('M j, Y') }}</td>
                                    <td class="px-6 py-4 flex items-center space-x-3">
                                        <div class="h-8 w-8 bg-indigo-500/10 text-indigo-400 font-bold rounded-full flex items-center justify-center text-xs border border-indigo-500/15 uppercase">
                                            {{ substr($att->user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-white text-xs">{{ $att->user->name }}</div>
                                            <div class="text-4xs text-slate-500 font-semibold uppercase tracking-wider mt-0.5">{{ $att->user->department }} Department</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-emerald-400 font-medium text-xs">{{ $att->check_in ? $att->check_in->format('h:i A') : 'N/A' }}</td>
                                    <td class="px-6 py-4 text-rose-400 font-medium text-xs">{{ $att->check_out ? $att->check_out->format('h:i A') : 'Active' }}</td>
                                    <td class="px-6 py-4 text-center text-amber-500 font-semibold text-xs">{{ $att->totalBreakMinutes() }} mins</td>
                                    <td class="px-6 py-4 text-center font-black text-white text-xs">{{ $att->total_hours ?? '0.00' }} hrs</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-4xs font-bold uppercase tracking-widest
                                            @if($att->status === 'present') bg-emerald-500/10 text-emerald-400 border border-emerald-500/15
                                            @elseif($att->status === 'half-day') bg-amber-500/10 text-amber-400 border border-amber-500/15
                                            @elseif($att->status === 'leave') bg-indigo-500/10 text-indigo-400 border border-indigo-500/15
                                            @else bg-rose-500/10 text-rose-400 border border-rose-500/15 @endif">
                                            {{ ucfirst($att->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-400 max-w-xxs" title="{{ $att->work_summary }}">
                                        @if($att->work_summary)
                                            <p class="truncate font-semibold text-slate-300">{{ $att->work_summary }}</p>
                                        @endif
                                        @if($att->work_document)
                                            <a href="{{ asset('storage/' . $att->work_document) }}" target="_blank" class="inline-block text-indigo-400 hover:text-indigo-300 font-bold text-4xs uppercase tracking-wider mt-1 flex items-center">
                                                <svg class="h-3.5 w-3.5 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Download Doc
                                            </a>
                                        @elseif(!$att->work_summary)
                                            <span class="text-slate-600 font-semibold">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $attendances->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
