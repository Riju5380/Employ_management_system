<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Today's Shift Activity") }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-150">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h2 class="text-lg font-bold text-gray-800">Shift Timeline</h2>
                    <p class="text-xs text-gray-400">Chronological history of today's events: {{ now()->format('l, F j, Y') }}</p>
                </div>

                @if(!$attendance)
                    <div class="text-center py-12 text-gray-400">
                        <svg class="h-16 w-16 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm">You haven't checked in for today yet.</p>
                        <a href="{{ route('dashboard') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold text-sm transition duration-150">Check In Now</a>
                    </div>
                @else
                    <div class="relative pl-6 border-l-2 border-slate-200 space-y-8 ml-4">
                        <!-- Step 1: Check In -->
                        <div class="relative">
                            <span class="absolute -left-[31px] top-0.5 bg-emerald-500 text-white rounded-full p-1.5 shadow-sm">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <div>
                                <h3 class="font-bold text-slate-800 text-sm">Checked In</h3>
                                <p class="text-xs text-emerald-600 font-semibold mt-0.5">{{ $attendance->check_in->format('h:i A') }}</p>
                                @if($attendance->notes)
                                    <p class="text-xs text-slate-500 bg-slate-50 p-2.5 rounded border border-gray-100 mt-2 font-normal">Notes: {{ $attendance->notes }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Step 2: Breaks -->
                        @foreach($attendance->breaks as $break)
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0.5 bg-amber-500 text-white rounded-full p-1.5 shadow-sm">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                <div>
                                    <h3 class="font-bold text-slate-800 text-sm">Break Record</h3>
                                    <p class="text-xs text-amber-600 font-semibold mt-0.5">
                                        Started: {{ $break->break_start->format('h:i A') }}
                                        @if($break->break_end)
                                            &bull; Ended: {{ $break->break_end->format('h:i A') }}
                                            &bull; Duration: {{ $break->duration_minutes }} mins
                                        @else
                                            &bull; Running...
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach

                        <!-- Step 3: Work Logs -->
                        @foreach($attendance->workLogs as $log)
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0.5 bg-blue-500 text-white rounded-full p-1.5 shadow-sm">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                                    </svg>
                                </span>
                                <div>
                                    <h3 class="font-bold text-slate-800 text-sm">Work Logged: {{ $log->title }}</h3>
                                    <p class="text-xs text-blue-600 font-semibold mt-0.5">{{ $log->duration_minutes }} mins &bull; {{ ucfirst($log->category) }}</p>
                                    @if($log->description)
                                        <p class="text-xs text-slate-500 mt-1 font-normal">{{ $log->description }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <!-- Step 4: Check Out -->
                        @if($attendance->check_out)
                            <div class="relative">
                                <span class="absolute -left-[31px] top-0.5 bg-rose-500 text-white rounded-full p-1.5 shadow-sm">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                                    </svg>
                                </span>
                                <div>
                                    <h3 class="font-bold text-slate-800 text-sm">Checked Out</h3>
                                    <p class="text-xs text-rose-600 font-semibold mt-0.5">{{ $attendance->check_out->format('h:i A') }}</p>
                                    <p class="text-xs text-slate-500 mt-2 font-semibold bg-emerald-50 text-emerald-800 p-2.5 rounded border border-emerald-100">
                                        Net shift duration: {{ $attendance->total_hours }} working hours (excluding breaks)
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
