<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6 text-slate-100 pb-12">

        <!-- Date Selector Card -->
        <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div>
                <h1 class="text-xl font-black text-white tracking-tight">Daily Activity Logs</h1>
                <p class="text-xs text-slate-500 font-semibold mt-0.5">View or modify work logged on a specific calendar day.</p>
            </div>
            <form method="GET" action="{{ route('work-logs.index') }}" class="flex items-center space-x-2">
                <input type="date" name="date" value="{{ $date }}" class="text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none p-2.5 transition duration-150">
                <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-xs transition duration-150 shadow shadow-indigo-600/15">Load Logs</button>
            </form>
        </div>

        <!-- Main Panel -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Log List -->
            <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl lg:col-span-2">
                <h2 class="text-md font-extrabold text-white mb-6 flex justify-between items-center">
                    <span>Work Entries for {{ \Carbon\Carbon::parse($date)->format('M j, Y') }}</span>
                    <span class="text-xs bg-slate-800 text-slate-400 font-semibold px-2.5 py-1 rounded-full border border-slate-700/30">{{ $workLogs->count() }} Entries</span>
                </h2>

                @if($workLogs->isEmpty())
                    <div class="text-center py-16 text-slate-500">
                        <svg class="h-12 w-12 mx-auto mb-3 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6M12 9v6m-7 6h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm font-semibold">No tasks logged on this day.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($workLogs as $log)
                            <div class="bg-[#0c0d12] p-4 rounded-xl border border-white/5 flex justify-between items-start">
                                <div class="space-y-1">
                                    <div class="flex items-center space-x-2.5">
                                        <h3 class="font-bold text-white text-sm">{{ $log->title }}</h3>
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-4xs font-bold uppercase tracking-widest
                                            @if($log->category === 'development') bg-blue-500/10 text-blue-400 border border-blue-500/15
                                            @elseif($log->category === 'meeting') bg-amber-500/10 text-amber-400 border border-amber-500/15
                                            @elseif($log->category === 'review') bg-purple-500/10 text-purple-400 border border-purple-500/15
                                            @elseif($log->category === 'support') bg-rose-500/10 text-rose-400 border border-rose-500/15
                                            @else bg-slate-800 text-slate-400 border border-slate-700/30 @endif">
                                            {{ ucfirst($log->category) }}
                                        </span>
                                    </div>
                                    @if($log->description)
                                        <p class="text-xs text-slate-400 font-medium">{{ $log->description }}</p>
                                    @endif
                                    <span class="text-4xs text-slate-500 font-semibold block uppercase tracking-wider">Logged duration: {{ $log->duration_minutes }} minutes</span>
                                </div>

                                @if(\Carbon\Carbon::parse($date)->isToday() && (!$attendance || !$attendance->check_out))
                                    <form action="{{ route('work-logs.destroy', $log) }}" method="POST" onsubmit="return confirm('Delete this log entry?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-400 font-bold text-xxs tracking-wider uppercase">Delete</button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Log Addition Sidebar (Only for Today) -->
            <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl lg:col-span-1">
                <h2 class="text-md font-extrabold text-white mb-3">Logging Status</h2>
                @if(\Carbon\Carbon::parse($date)->isToday())
                    @if($attendance && !$attendance->check_out)
                        <p class="text-xs text-slate-500 mb-6 font-semibold">You are clocked in for today's shift and can log tasks. Add entries using the dashboard control panel.</p>
                        <a href="{{ route('dashboard') }}" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs transition duration-150 shadow shadow-indigo-600/15">
                            Open Dashboard Controls
                        </a>
                    @else
                        <div class="bg-[#0c0d12] p-4 rounded-xl border border-white/5 text-center text-xs text-slate-500 font-semibold">
                            You must have an active shift (checked in and not checked out) to log work.
                        </div>
                    @endif
                @else
                    <div class="bg-[#0c0d12] p-4 rounded-xl border border-white/5 text-center text-xs text-slate-500 font-semibold">
                        Editing logs is restricted to the current active date only. Previous date records are finalized for audit purposes.
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
