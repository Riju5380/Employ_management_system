<nav class="w-64 bg-[#13151c] border-r border-[#1f222e] h-screen flex flex-col justify-between p-6">
    <!-- Top Identity Area -->
    <div class="flex flex-col space-y-8">
        
        <!-- Logo block -->
        <div class="flex items-center space-x-3 mt-2">
            <!-- Sleek Icon -->
            <div class="h-10 w-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-600/35">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold text-white tracking-wider uppercase">Chronos HR</h2>
                <span class="text-3xs text-slate-400 font-semibold uppercase tracking-widest block">ATTENDANCE</span>
            </div>
        </div>

        <!-- Links list -->
        <div class="flex flex-col space-y-1">
            <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest mb-2 pl-3">Main Directory</span>
            
            <!-- Dashboard link -->
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition duration-150 group 
                {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')
                    ? 'bg-[#1f222e] text-white border-l-2 border-indigo-500 shadow-sm active-glow' 
                    : 'text-slate-400 hover:text-white hover:bg-slate-800/25' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                </svg>
                <span>Dashboard</span>
            </a>

            @if(Auth::user()->isAdmin())
                <!-- Admin: Attendance Logs -->
                <a href="{{ route('admin.attendance') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition duration-150 group
                    {{ request()->routeIs('admin.attendance') 
                        ? 'bg-[#1f222e] text-white border-l-2 border-indigo-500 shadow-sm active-glow' 
                        : 'text-slate-400 hover:text-white hover:bg-slate-800/25' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                    </svg>
                    <span>All Attendance</span>
                </a>

                <!-- Admin: Employees List -->
                <a href="{{ route('admin.employees') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition duration-150 group
                    {{ request()->routeIs('admin.employees') 
                        ? 'bg-[#1f222e] text-white border-l-2 border-indigo-500 shadow-sm active-glow' 
                        : 'text-slate-400 hover:text-white hover:bg-slate-800/25' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Employees</span>
                </a>
            @else
                <!-- Employee: Today's Shift Logs -->
                <a href="{{ route('attendance.today') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition duration-150 group
                    {{ request()->routeIs('attendance.today') 
                        ? 'bg-[#1f222e] text-white border-l-2 border-indigo-500 shadow-sm active-glow' 
                        : 'text-slate-400 hover:text-white hover:bg-slate-800/25' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Today's Log</span>
                </a>

                <!-- Employee: History -->
                <a href="{{ route('attendance.my-history') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition duration-150 group
                    {{ request()->routeIs('attendance.my-history') 
                        ? 'bg-[#1f222e] text-white border-l-2 border-indigo-500 shadow-sm active-glow' 
                        : 'text-slate-400 hover:text-white hover:bg-slate-800/25' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>My Attendance</span>
                </a>

                <!-- Employee: Work Log index -->
                <a href="{{ route('work-logs.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition duration-150 group
                    {{ request()->routeIs('work-logs.*') 
                        ? 'bg-[#1f222e] text-white border-l-2 border-indigo-500 shadow-sm active-glow' 
                        : 'text-slate-400 hover:text-white hover:bg-slate-800/25' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span>Work Log</span>
                </a>

                <!-- Employee: Leave Request -->
                <a href="{{ route('leaves.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition duration-150 group
                    {{ request()->routeIs('leaves.*') 
                        ? 'bg-[#1f222e] text-white border-l-2 border-indigo-500 shadow-sm active-glow' 
                        : 'text-slate-400 hover:text-white hover:bg-slate-800/25' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Leave Request</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Bottom Controls Area -->
    <div class="flex flex-col space-y-1 mb-2">
        <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest mb-2 pl-3">Personal Panel</span>
        
        <!-- Profile Standard link -->
        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-400 hover:text-white hover:bg-slate-800/25 transition duration-150 group">
            <svg class="h-5 w-5 text-slate-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Profile</span>
        </a>

        <!-- Settings / Stub link -->
        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-400 hover:text-white hover:bg-slate-800/25 transition duration-150 group">
            <svg class="h-5 w-5 text-slate-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Settings</span>
        </a>

        <!-- Logout Action link -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold text-rose-400 hover:text-rose-350 hover:bg-rose-500/10 transition duration-150 text-left">
                <svg class="h-5 w-5 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</nav>
