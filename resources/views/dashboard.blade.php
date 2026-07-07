<x-app-layout>
    <div x-data="{ showCheckoutModal: false, showAddLogModal: false }" class="max-w-7xl mx-auto space-y-6 text-slate-100 pb-12">
        
        <!-- Header Clock Row -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl">
            <div>
                <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest">{{ now()->format('l, F j, Y') }}</span>
                <!-- Ticking clock -->
                <h1 class="text-4xl font-black text-white mt-1 tracking-tight" id="hero-realtime-clock">
                    {{ now()->format('H:i:s') }}
                </h1>
            </div>
            
            <div class="flex items-center space-x-3 mt-4 md:mt-0">
                <a href="{{ route('leaves.create') }}" class="px-4 py-2.5 bg-[#1d1f27] hover:bg-[#252834] text-slate-300 font-semibold rounded-xl text-sm border border-[#2e3347] transition duration-150 flex items-center space-x-2">
                    <svg class="h-4.5 w-4.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Quick Leave</span>
                </a>

                @if(!$todayAttendance)
                    <!-- Clock In -->
                    <form action="{{ route('attendance.check-in') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-slate-900 font-bold rounded-xl text-sm shadow-lg shadow-emerald-500/25 transition duration-150 flex items-center space-x-2">
                            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span>Clock In</span>
                        </button>
                    </form>
                @elseif($isCheckedIn)
                    <!-- Clock Out Button Triggers Alpine Modal -->
                    <button @click="showCheckoutModal = true" class="px-5 py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-xl text-sm shadow-lg shadow-rose-500/20 transition duration-150 flex items-center space-x-2">
                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                        </svg>
                        <span>Clock Out</span>
                    </button>
                @else
                    <!-- Checked out -->
                    <button disabled class="px-5 py-2.5 bg-slate-800 text-slate-500 font-bold rounded-xl text-sm cursor-not-allowed flex items-center space-x-2">
                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Shift Finished</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- Shift Live Status Panel -->
        <div class="bg-[#13151c] rounded-2xl border border-white/5 p-6 shadow-xl flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <!-- Status Icon Widget -->
                <div class="h-14 w-14 rounded-2xl flex items-center justify-center 
                    @if(!$todayAttendance) bg-slate-800/40 text-slate-400
                    @elseif($activeBreak) bg-amber-500/10 text-amber-500 border border-amber-500/20
                    @elseif($isCheckedIn) bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 active-glow
                    @else bg-blue-500/10 text-blue-500 border border-blue-500/20 @endif">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if($activeBreak)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        @elseif($isCheckedIn)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        @endif
                    </svg>
                </div>

                <div>
                    <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">Current Status</span>
                    <h3 class="text-lg font-bold text-white mt-0.5">
                        @if(!$todayAttendance) Not Checked In
                        @elseif($activeBreak) On Break
                        @elseif($isCheckedIn) Clocked In
                        @else Checked Out (Completed)
                        @endif
                    </h3>
                </div>
            </div>

            <!-- Elapsed Session Time Ticker -->
            <div class="text-center md:text-left">
                <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">Elapsed Session Time</span>
                <h3 class="text-2xl font-black tracking-tight text-slate-100 mt-0.5" id="session-elapsed-timer">
                    00:00:00
                </h3>
            </div>

            <!-- Break Controls & Add Log Button -->
            <div class="flex items-center space-x-2">
                @if($isCheckedIn)
                    @if(!$activeBreak)
                        <form action="{{ route('attendance.break.start') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-[#1d1f27] hover:bg-[#252834] border border-[#2e3347] text-slate-200 font-semibold rounded-xl text-xs transition duration-150">
                                Start Break
                            </button>
                        </form>
                    @else
                        <form action="{{ route('attendance.break.end') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold rounded-xl text-xs shadow shadow-amber-500/10 transition duration-150">
                                End Break
                            </button>
                        </form>
                    @endif

                    <button @click="showAddLogModal = true" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs shadow-md shadow-indigo-600/15 transition duration-150">
                        Add Log
                    </button>
                @else
                    <button disabled class="px-4 py-2 bg-slate-800/40 text-slate-600 border border-white/5 rounded-xl text-xs cursor-not-allowed">
                        Start Break
                    </button>
                    <button disabled class="px-4 py-2 bg-slate-800/40 text-slate-600 border border-white/5 rounded-xl text-xs cursor-not-allowed">
                        Add Log
                    </button>
                @endif
            </div>
        </div>

        <!-- Metrics Grid (Mockup #1 themed) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Present Days -->
            <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl flex items-center justify-between">
                <div>
                    <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">Present Days</span>
                    <h2 class="text-2xl font-black text-white mt-1.5">{{ $presentDays }} <span class="text-slate-500 font-bold text-sm">/ 22</span></h2>
                </div>
                <div class="flex flex-col items-end space-y-2">
                    <span class="px-2 py-0.5 rounded-full text-4xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">+2 today</span>
                    <div class="p-2.5 bg-emerald-500/10 text-emerald-400 rounded-xl border border-emerald-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Hours -->
            <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl flex items-center justify-between">
                <div>
                    <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">Total Hours</span>
                    <h2 class="text-2xl font-black text-white mt-1.5">{{ number_format($totalHours, 1) }} <span class="text-slate-500 font-bold text-sm">hrs</span></h2>
                </div>
                <div class="flex flex-col items-end space-y-2">
                    <span class="px-2 py-0.5 rounded-full text-4xs font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">8.5h avg</span>
                    <div class="p-2.5 bg-indigo-500/10 text-indigo-400 rounded-xl border border-indigo-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Breaks Taken -->
            <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl flex items-center justify-between">
                <div>
                    <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">Breaks Taken</span>
                    <h2 class="text-2xl font-black text-white mt-1.5">
                        @if($todayAttendance)
                            {{ $todayAttendance->breaks->count() }} <span class="text-slate-500 font-bold text-sm">times</span>
                        @else
                            0 <span class="text-slate-500 font-bold text-sm">times</span>
                        @endif
                    </h2>
                </div>
                <div class="flex flex-col items-end space-y-2">
                    <span class="px-2 py-0.5 rounded-full text-4xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">45m avg</span>
                    <div class="p-2.5 bg-amber-500/10 text-amber-400 rounded-xl border border-amber-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Leaves -->
            <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl flex items-center justify-between">
                <div>
                    <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">Leaves Request</span>
                    <h2 class="text-2xl font-black text-white mt-1.5">{{ sprintf("%02d", $leavesTaken) }} <span class="text-slate-500 font-bold text-sm">days</span></h2>
                </div>
                <div class="flex flex-col items-end space-y-2">
                    <span class="px-2 py-0.5 rounded-full text-4xs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/20">2 pending</span>
                    <div class="p-2.5 bg-rose-500/10 text-rose-400 rounded-xl border border-rose-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Work Log Audit Table (Mockup #1 themed) -->
        <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-md font-extrabold text-white tracking-wide">Today's Work Log</h2>
                    <span class="text-4xs text-slate-500 font-bold uppercase tracking-widest block mt-0.5">Chronological record of achievements</span>
                </div>
                @if($isCheckedIn)
                    <button @click="showAddLogModal = true" class="px-3.5 py-2 bg-indigo-600/10 hover:bg-indigo-600/20 border border-indigo-500/20 text-indigo-400 font-bold text-xs rounded-xl transition duration-150 flex items-center space-x-1">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>New Entry</span>
                    </button>
                @endif
            </div>

            @if($todayWorkLogs->isEmpty())
                <div class="text-center py-16 text-slate-500">
                    <svg class="h-12 w-12 mx-auto mb-3 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <p class="text-sm font-semibold">No shift activity entries found for today.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-slate-300 text-sm">
                        <thead>
                            <tr class="text-left text-xxs font-bold text-slate-500 uppercase tracking-widest border-b border-[#1f222e]">
                                <th class="px-6 py-3">Time Range</th>
                                <th class="px-6 py-3">Activity</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-center">Duration</th>
                                <th class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#1f222e]/45">
                            @foreach($todayWorkLogs as $index => $log)
                                <tr class="hover:bg-white/10 transition duration-150">
                                    <td class="px-6 py-4 text-xs font-semibold text-slate-400">
                                        <!-- Estimated time stamp relative to creation time -->
                                        {{ $log->created_at->format('h:i A') }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-white flex items-center space-x-2.5">
                                        <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                                        <div>
                                            <span>{{ $log->title }}</span>
                                            @if($log->description)
                                                <p class="text-xxs font-normal text-slate-500 mt-0.5">{{ $log->description }}</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-4xs font-bold uppercase tracking-widest bg-emerald-500/10 text-emerald-400 border border-emerald-500/15">
                                            Completed
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-xs font-bold text-slate-300">{{ $log->duration_minutes }} mins</td>
                                    <td class="px-6 py-4 text-right">
                                        @if($isCheckedIn)
                                            <form action="{{ route('work-logs.destroy', $log) }}" method="POST" onsubmit="return confirm('Delete this log entry?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-500 hover:text-rose-450 font-bold text-xxs tracking-wider uppercase">Delete</button>
                                            </form>
                                        @else
                                            <span class="text-slate-600 font-bold text-xxs uppercase">Locked</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- 🚀 MODAL 1: MANDATORY CHECKOUT WORK LOG MODAL (Alpine.js) -->
        <div x-show="showCheckoutModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-[#0c0d12]/80 backdrop-blur-md transition-opacity"></div>
            
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
                <div class="relative inline-block w-full max-w-lg p-8 overflow-hidden text-left align-middle transition-all transform bg-[#13151c] border border-white/5 rounded-2xl shadow-2xl z-50">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-black text-white flex items-center">
                            <svg class="h-6 w-6 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                            </svg>
                            Finalize Shift & Clock Out
                        </h3>
                        <button @click="showCheckoutModal = false" class="text-slate-500 hover:text-white transition duration-150">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <p class="text-xs text-slate-400 mb-6 font-semibold">
                        To successfully finalize and clock out of your shift, you must submit a summary of today's achievements or upload a completed work document (PDF, Word, zip, or image).
                    </p>

                    <!-- Checkout Form -->
                    <form action="{{ route('attendance.check-out') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        
                        <!-- Summary -->
                        <div>
                            <label for="work_summary" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">Today's Work Summary</label>
                            <textarea id="work_summary" name="work_summary" rows="4" placeholder="Describe your achievements today..."
                                class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white placeholder-slate-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none p-3.5 transition duration-150"></textarea>
                        </div>

                        <!-- Document Upload -->
                        <div>
                            <label for="work_document" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">Upload Supporting Document</label>
                            <input type="file" id="work_document" name="work_document" 
                                class="block w-full text-xs text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600/10 file:text-indigo-400 hover:file:bg-indigo-600/20 file:cursor-pointer bg-[#0c0d12] border border-[#1f222e] rounded-xl focus:outline-none p-2.5">
                        </div>

                        <!-- Footer Actions -->
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-[#1f222e]">
                            <button type="button" @click="showCheckoutModal = false" class="px-4 py-2.5 bg-[#1d1f27] hover:bg-[#252834] text-slate-300 font-semibold rounded-xl text-sm border border-[#2e3347] transition duration-150">
                                Cancel
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-500 text-white font-bold rounded-xl text-sm transition duration-150 shadow-lg shadow-rose-600/15">
                                Finalize & Clock Out
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 🚀 MODAL 2: ADD WORK LOG ENTRY (Alpine.js) -->
        <div x-show="showAddLogModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-[#0c0d12]/80 backdrop-blur-md transition-opacity"></div>
            
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
                <div class="relative inline-block w-full max-w-md p-8 overflow-hidden text-left align-middle transition-all transform bg-[#13151c] border border-white/5 rounded-2xl shadow-2xl z-50">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-black text-white">Log Work Entry</h3>
                        <button @click="showAddLogModal = false" class="text-slate-500 hover:text-white transition duration-150">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('work-logs.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="title" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">Task Title</label>
                            <input type="text" name="title" id="title" required placeholder="e.g. Refactored login page UI"
                                class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white placeholder-slate-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none px-4 py-3 transition duration-150">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="category" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">Category</label>
                                <select name="category" id="category" required 
                                    class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none px-4 py-3 transition duration-150">
                                    <option value="development">Development</option>
                                    <option value="meeting">Meeting</option>
                                    <option value="review">Review</option>
                                    <option value="support">Support</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label for="duration_minutes" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">Duration (Mins)</label>
                                <input type="number" name="duration_minutes" id="duration_minutes" required min="1" max="1440" placeholder="e.g. 60"
                                    class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white placeholder-slate-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none px-4 py-3 transition duration-150">
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">Detailed Description</label>
                            <textarea name="description" id="description" rows="3" placeholder="Summary of what was achieved..."
                                class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white placeholder-slate-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none p-3.5 transition duration-150"></textarea>
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-[#1f222e]">
                            <button type="button" @click="showAddLogModal = false" class="px-4 py-2.5 bg-[#1d1f27] hover:bg-[#252834] text-slate-300 font-semibold rounded-xl text-sm border border-[#2e3347] transition duration-150">
                                Cancel
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition duration-150">
                                Save Log Entry
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Client-side Timer logic for active shift (if clocked in) -->
    <script>
        // Real-time Clock Row ticker
        setInterval(() => {
            const clockEl = document.getElementById('hero-realtime-clock');
            if (clockEl) {
                const date = new Date();
                clockEl.innerText = date.toTimeString().split(' ')[0];
            }
        }, 1000);

        // Elapsed Session shift ticker
        @if($isCheckedIn && $todayAttendance)
            const checkInTime = new Date("{{ $todayAttendance->check_in->toIso8601String() }}").getTime();
            
            // We subtract the accumulated break time (if any) to get the true net working time!
            const totalBreakMins = {{ $todayAttendance->totalBreakMinutes() }};
            const totalBreakMs = totalBreakMins * 60 * 1000;

            // Is currently on break?
            const isOnBreak = {{ $activeBreak ? 'true' : 'false' }};
            
            // If currently on break, we also need to add the active break elapsed time
            let activeBreakStart = 0;
            @if($activeBreak)
                activeBreakStart = new Date("{{ $activeBreak->break_start->toIso8601String() }}").getTime();
            @endif

            setInterval(() => {
                const timerEl = document.getElementById('session-elapsed-timer');
                if (timerEl) {
                    const now = new Date().getTime();
                    
                    let elapsedMs = now - checkInTime - totalBreakMs;
                    
                    if (isOnBreak) {
                        // Subtract the running active break time too!
                        const activeBreakElapsed = now - activeBreakStart;
                        elapsedMs = elapsedMs - activeBreakElapsed;
                    }

                    if (elapsedMs < 0) elapsedMs = 0;

                    const totalSecs = Math.floor(elapsedMs / 1000);
                    const hours = Math.floor(totalSecs / 3600);
                    const minutes = Math.floor((totalSecs % 3600) / 60);
                    const seconds = totalSecs % 60;

                    const pad = (num) => String(num).padStart(2, '0');
                    timerEl.innerText = `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
                }
            }, 1000);
        @endif
    </script>
</x-app-layout>
