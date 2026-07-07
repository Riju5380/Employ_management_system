<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6 text-slate-100 pb-12">
        
        <div class="flex justify-between items-center bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl">
            <div>
                <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">Time Tracking</span>
                <h1 class="text-2xl font-black text-white mt-1 tracking-tight">Attendance History</h1>
            </div>
            
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 bg-indigo-600/10 text-indigo-400 text-xxs font-bold uppercase tracking-wider rounded-lg border border-indigo-500/20">Monthly</span>
                <span class="px-3 py-1 bg-[#1d1f27] text-slate-400 text-xxs font-bold uppercase tracking-wider rounded-lg border border-[#2e3347] cursor-pointer hover:text-white">Weekly</span>
            </div>
        </div>

        <!-- Analytics Row (Mockup #3) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Calendar Card / Presence Card (2/3 width) -->
            <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl lg:col-span-2 flex flex-col justify-between">
                <div>
                    <h2 class="text-md font-extrabold text-white tracking-wide">Presence Calendar</h2>
                    <span class="text-4xs text-slate-500 font-bold uppercase tracking-widest block mt-0.5">Chronological month layout</span>
                </div>

                <!-- Minimalist attendance visual blocks for this month -->
                <div class="grid grid-cols-7 gap-2.5 my-6 max-w-md">
                    @for ($i = 1; $i <= 31; $i++)
                        <div class="h-9 w-9 rounded-xl flex items-center justify-center text-xs font-bold border
                            @if($i <= $attendances->total()) bg-emerald-500/10 text-emerald-400 border-emerald-500/20
                            @elseif($i === 12 || $i === 13) bg-rose-500/10 text-rose-400 border-rose-500/20
                            @else bg-[#0c0d12] text-slate-600 border-white/5 @endif" title="Day {{ $i }}">
                            {{ $i }}
                        </div>
                    @endfor
                </div>

                <div class="flex items-center space-x-4 border-t border-[#1f222e] pt-4 text-xxs font-bold uppercase tracking-widest text-slate-500">
                    <span class="flex items-center"><span class="h-2 w-2 rounded-full bg-emerald-400 mr-1.5"></span> Present</span>
                    <span class="flex items-center"><span class="h-2 w-2 rounded-full bg-rose-400 mr-1.5"></span> Absent</span>
                    <span class="flex items-center"><span class="h-2 w-2 rounded-full bg-slate-600 mr-1.5"></span> Pending</span>
                </div>
            </div>

            <!-- Insights Column (1/3 width) -->
            <div class="space-y-6 lg:col-span-1">
                <!-- Monthly Attendance -->
                <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl flex justify-between items-center">
                    <div>
                        <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">Monthly Attendance</span>
                        <h2 class="text-3xl font-black text-emerald-400 mt-2">92.5%</h2>
                    </div>
                    <div class="text-right">
                        <span class="text-xxs font-bold text-white block">18 / 20 Days</span>
                        <span class="text-4xs text-slate-500 font-bold block mt-0.5">Above target (+2.1%)</span>
                    </div>
                </div>

                <!-- Punctuality Rate -->
                <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl flex justify-between items-center">
                    <div>
                        <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">Punctuality Rate</span>
                        <h2 class="text-3xl font-black text-amber-500 mt-2">85%</h2>
                    </div>
                    <div class="text-right">
                        <span class="text-xxs font-bold text-white block">3 Late Entries</span>
                        <span class="text-4xs text-slate-500 font-bold block mt-0.5">Avg: 8min late</span>
                    </div>
                </div>

                <!-- Quick Insights -->
                <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl">
                    <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block mb-4">Quick Insights</span>
                    <div class="space-y-3 text-xxs font-semibold">
                        <div class="flex items-center space-x-2">
                            <span class="p-1 bg-emerald-500/10 text-emerald-400 rounded-md border border-emerald-500/15">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </span>
                            <span class="text-slate-300">Most productive on Tuesdays (Avg 9.2h)</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="p-1 bg-rose-500/10 text-rose-400 rounded-md border border-rose-500/15">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                </svg>
                            </span>
                            <span class="text-slate-300">Frequent late arrivals on Monday mornings</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Daily Logs Table -->
        <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl">
            <h2 class="text-md font-extrabold text-white tracking-wide mb-6">Daily Logs</h2>

            @if($attendances->isEmpty())
                <div class="text-center py-12 text-slate-500">
                    <p class="text-sm font-semibold">No historical shift records found.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-slate-300 text-sm">
                        <thead>
                            <tr class="text-left text-xxs font-bold text-slate-500 uppercase tracking-widest border-b border-[#1f222e]">
                                <th class="px-6 py-3">Date</th>
                                <th class="px-6 py-3">Clock In</th>
                                <th class="px-6 py-3">Clock Out</th>
                                <th class="px-6 py-3 text-center">Work Hours</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3">Work Summary</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#1f222e]/45">
                            @foreach($attendances as $att)
                                <tr class="hover:bg-white/5 transition duration-150">
                                    <td class="px-6 py-4 font-bold text-white text-xs">{{ $att->date->format('M j, Y') }}</td>
                                    <td class="px-6 py-4 text-xs font-semibold text-emerald-400">{{ $att->check_in ? $att->check_in->format('h:i A') : 'N/A' }}</td>
                                    <td class="px-6 py-4 text-xs font-semibold text-rose-400">{{ $att->check_out ? $att->check_out->format('h:i A') : 'Active' }}</td>
                                    <td class="px-6 py-4 text-center font-black text-white text-xs">{{ $att->total_hours ?? '0.0' }} hrs</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-4xs font-bold uppercase tracking-widest
                                            @if($att->status === 'present') bg-emerald-500/10 text-emerald-400 border border-emerald-500/15
                                            @elseif($att->status === 'half-day') bg-amber-500/10 text-amber-400 border border-amber-500/15
                                            @elseif($att->status === 'leave') bg-indigo-500/10 text-indigo-400 border border-indigo-500/15
                                            @else bg-rose-500/10 text-rose-400 border border-rose-500/15 @endif">
                                            {{ ucfirst($att->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-400 max-w-xxs truncate" title="{{ $att->work_summary }}">
                                        @if($att->work_summary)
                                            {{ $att->work_summary }}
                                            @if($att->work_document)
                                                <a href="{{ asset('storage/' . $att->work_document) }}" target="_blank" class="block text-indigo-400 hover:underline font-bold text-3xs uppercase tracking-wider mt-1">📄 Download Document</a>
                                            @endif
                                        @else
                                            -
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
