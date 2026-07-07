<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6 text-slate-100 pb-12">

        <!-- Command Stats Cards (Mockup #2) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Stat 1: Present -->
            <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl flex items-center justify-between">
                <div>
                    <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">Today Present</span>
                    <h2 class="text-3xl font-black text-white mt-1.5">{{ sprintf("%02d", $presentToday) }}</h2>
                </div>
                <div class="flex flex-col items-end space-y-2">
                    <span class="px-2 py-0.5 rounded-full text-4xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">+12%</span>
                    <div class="p-2.5 bg-emerald-500/10 text-emerald-400 rounded-xl border border-emerald-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stat 2: Absent -->
            <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl flex items-center justify-between">
                <div>
                    <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">Today Absent</span>
                    <h2 class="text-3xl font-black text-rose-500 mt-1.5">{{ sprintf("%02d", $absentToday) }}</h2>
                </div>
                <div class="flex flex-col items-end space-y-2">
                    <span class="px-2 py-0.5 rounded-full text-4xs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/20">-2%</span>
                    <div class="p-2.5 bg-rose-500/10 text-rose-400 rounded-xl border border-rose-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stat 3: On Break -->
            <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl flex items-center justify-between">
                <div>
                    <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">On Break Now</span>
                    <h2 class="text-3xl font-black text-amber-500 mt-1.5">{{ sprintf("%02d", $onBreakToday) }}</h2>
                </div>
                <div class="flex flex-col items-end space-y-2">
                    <span class="px-2 py-0.5 rounded-full text-4xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">Real-time</span>
                    <div class="p-2.5 bg-amber-500/10 text-amber-400 rounded-xl border border-amber-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stat 4: Pending Leaves -->
            <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl flex items-center justify-between">
                <div>
                    <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">Pending Leaves</span>
                    <h2 class="text-3xl font-black text-indigo-400 mt-1.5">{{ sprintf("%02d", $pendingLeaves->count()) }}</h2>
                </div>
                <div class="flex flex-col items-end space-y-2">
                    <span class="px-2 py-0.5 rounded-full text-4xs font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Action Needed</span>
                    <div class="p-2.5 bg-indigo-500/10 text-indigo-400 rounded-xl border border-indigo-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M12 9v6m-7 6h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Attendance and Monthly Analytics Panel (Mockup #2 themed) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Live Attendance table (2/3 width) -->
            <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl lg:col-span-2">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-md font-extrabold text-white tracking-wide flex items-center">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-ping mr-2"></span>
                            Live Attendance
                        </h2>
                        <span class="text-4xs text-slate-500 font-bold uppercase tracking-widest block mt-0.5">Real-time working sessions</span>
                    </div>
                    <a href="{{ route('admin.attendance') }}" class="text-xxs font-bold text-indigo-400 hover:text-indigo-300 uppercase tracking-widest">View All</a>
                </div>

                @if($recentActivity->isEmpty())
                    <div class="text-center py-16 text-slate-500">
                        <p class="text-sm font-semibold">No active shifts logged for today yet.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-slate-300 text-sm">
                            <thead>
                                <tr class="text-left text-xxs font-bold text-slate-500 uppercase tracking-widest border-b border-[#1f222e]">
                                    <th class="px-6 py-3">Employee</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Check In</th>
                                    <th class="px-6 py-3 text-center">Working Hours</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#1f222e]/45">
                                @foreach($recentActivity as $act)
                                    @php
                                        // Calculate elapsed session minutes for progress bar
                                        $checkIn = $act->check_in;
                                        $checkOut = $act->check_out ?? now();
                                        $workedMinutes = $checkIn->diffInMinutes($checkOut) - $act->totalBreakMinutes();
                                        $workedMinutes = max(0, $workedMinutes);
                                        $workedHours = round($workedMinutes / 60, 1);
                                        
                                        // Progress bar percent (base on 8 hours shift = 480 mins)
                                        $percent = min(100, round(($workedMinutes / 480) * 100));

                                        // Status string
                                        $onBreak = \App\Models\BreakRecord::where('attendance_id', $act->id)->whereNull('break_end')->exists();
                                    @endphp
                                    <tr class="hover:bg-white/5 transition duration-150">
                                        <td class="px-6 py-4 flex items-center space-x-3">
                                            <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-indigo-500/30 to-indigo-500/10 text-indigo-300 font-bold flex items-center justify-center text-xs shadow-sm uppercase border border-indigo-500/15">
                                                {{ substr($act->user->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-white text-xs">{{ $act->user->name }}</div>
                                                <div class="text-4xs text-slate-500 font-semibold uppercase tracking-wider mt-0.5">{{ $act->user->position }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($act->check_out)
                                                <span class="inline-flex px-2 py-0.5 rounded-full text-4xs font-bold uppercase tracking-widest bg-slate-800 text-slate-400 border border-slate-700/30">Checked Out</span>
                                            @elseif($onBreak)
                                                <span class="inline-flex px-2 py-0.5 rounded-full text-4xs font-bold uppercase tracking-widest bg-amber-500/10 text-amber-400 border border-amber-500/15 animate-pulse">On Break</span>
                                            @else
                                                <span class="inline-flex px-2 py-0.5 rounded-full text-4xs font-bold uppercase tracking-widest bg-emerald-500/10 text-emerald-400 border border-emerald-500/15 active-glow">Present</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-xs font-semibold text-slate-400">
                                            {{ $act->check_in->format('h:i:s A') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3 justify-end">
                                                <!-- Custom Progress bar -->
                                                <div class="w-24 bg-[#0c0d12] rounded-full h-1.5 border border-white/5 overflow-hidden">
                                                    <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ $percent }}%"></div>
                                                </div>
                                                <span class="text-xs font-bold text-white">
                                                    @if($act->check_out)
                                                        {{ $act->total_hours }}h
                                                    @else
                                                        {{ floor($workedMinutes / 60) }}h {{ $workedMinutes % 60 }}m
                                                    @endif
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Monthly Summary Panel (1/3 width) -->
            <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl lg:col-span-1 flex flex-col justify-between">
                <div>
                    <h2 class="text-md font-extrabold text-white tracking-wide">Monthly Summary</h2>
                    <span class="text-4xs text-slate-500 font-bold uppercase tracking-widest block mt-0.5">Overall presence metrics</span>
                </div>

                <!-- Beautiful Stats Display -->
                <div class="space-y-6 my-6">
                    <!-- Avg Attendance -->
                    <div class="bg-[#0c0d12] p-4 rounded-xl border border-white/5 flex items-center justify-between">
                        <div>
                            <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">Avg Attendance</span>
                            <h3 class="text-xl font-black text-indigo-400 mt-1">94.2%</h3>
                        </div>
                        <div class="text-right">
                            <span class="text-3xs text-emerald-400 font-semibold block">+2.1% target</span>
                        </div>
                    </div>

                    <!-- Overtime Total -->
                    <div class="bg-[#0c0d12] p-4 rounded-xl border border-white/5 flex items-center justify-between">
                        <div>
                            <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">Overtime Total</span>
                            <h3 class="text-xl font-black text-amber-500 mt-1">124h</h3>
                        </div>
                        <div class="text-right">
                            <span class="text-3xs text-slate-400 font-semibold block">Across 12 staff</span>
                        </div>
                    </div>
                </div>

                <!-- Minimalistic decorative chart bars matching Mockup #2 -->
                <div class="h-28 flex items-end justify-between px-4 pt-4 border-t border-[#1f222e]">
                    <div class="w-3 bg-indigo-500 rounded-t h-[75%]" title="Mon"></div>
                    <div class="w-3 bg-indigo-500 rounded-t h-[85%]" title="Tue"></div>
                    <div class="w-3 bg-indigo-500 rounded-t h-[92%]" title="Wed"></div>
                    <div class="w-3 bg-indigo-600 rounded-t h-[98%] active-glow" title="Thu"></div>
                    <div class="w-3 bg-indigo-500 rounded-t h-[80%]" title="Fri"></div>
                    <div class="w-3 bg-slate-800 rounded-t h-[25%]" title="Sat"></div>
                </div>
            </div>
        </div>

        <!-- Pending Leave Requests Card (Mockup #2 themed) -->
        <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl">
            <h2 class="text-md font-extrabold text-white tracking-wide mb-6">Pending Leave Requests</h2>

            @if($pendingLeaves->isEmpty())
                <div class="text-center py-12 text-slate-500">
                    <svg class="h-12 w-12 mx-auto mb-3 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-semibold">No pending leave applications at this time.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-slate-300 text-sm">
                        <thead>
                            <tr class="text-left text-xxs font-bold text-slate-500 uppercase tracking-widest border-b border-[#1f222e]">
                                <th class="px-6 py-3">Employee</th>
                                <th class="px-6 py-3">Reason</th>
                                <th class="px-6 py-3">Dates</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#1f222e]/45">
                            @foreach($pendingLeaves as $leave)
                                <tr class="hover:bg-white/5 transition duration-150">
                                    <td class="px-6 py-4 flex items-center space-x-3">
                                        <div class="h-8 w-8 bg-indigo-500/10 text-indigo-400 font-bold rounded-full flex items-center justify-center text-xs border border-indigo-500/15 uppercase">
                                            {{ substr($leave->user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-white text-xs">{{ $leave->user->name }}</div>
                                            <div class="text-4xs text-slate-500 font-semibold uppercase tracking-wider mt-0.5">{{ $leave->user->department }} Department</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 italic text-slate-400 text-xs">
                                        "{{ $leave->reason }}"
                                    </td>
                                    <td class="px-6 py-4 text-xs font-semibold text-slate-400">
                                        <div class="flex items-center space-x-2">
                                            <span>{{ $leave->from_date->format('M j') }}</span>
                                            <span class="text-slate-600">to</span>
                                            <span>{{ $leave->to_date->format('M j, Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <form action="{{ route('admin.leaves.approve', $leave) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-emerald-500/15 hover:bg-emerald-500/25 border border-emerald-500/35 text-emerald-400 rounded-xl text-xxs font-bold uppercase tracking-wider transition duration-150">
                                                Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.leaves.reject', $leave) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-rose-500/15 hover:bg-rose-500/25 border border-rose-500/35 text-rose-400 rounded-xl text-xxs font-bold uppercase tracking-wider transition duration-150">
                                                Reject
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
