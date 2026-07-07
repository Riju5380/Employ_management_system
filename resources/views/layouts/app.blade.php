<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Chronos HR') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#0c0d12] text-slate-100 min-h-screen">
        <div class="flex h-screen overflow-hidden">
            
            <!-- Left Vertical Sidebar -->
            @include('layouts.navigation')

            <!-- Right Main Content Panel -->
            <div class="flex-1 flex flex-col overflow-hidden">
                
                <!-- Custom Premium Top-bar -->
                <header class="h-16 border-b border-[#1f222e] bg-[#13151c]/45 backdrop-blur-md px-8 flex items-center justify-between z-10">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-semibold text-slate-400">
                            @if(Auth::user()->isAdmin())
                                {{ __('Good morning, Admin') }}
                            @else
                                {{ __('Good morning, ') . Auth::user()->name }}
                            @endif
                        </span>
                        <span class="text-slate-600">|</span>
                        <span class="text-xs font-medium text-indigo-400" id="header-realtime-clock">{{ now()->format('h:i:s A') }}</span>
                    </div>

                    <!-- Top Right User Profile Widget -->
                    <div class="flex items-center space-x-4">
                        <button class="text-slate-400 hover:text-white transition duration-150 relative">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <!-- Pending notifications dot -->
                            @if(Auth::user()->isAdmin())
                                <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span>
                            @endif
                        </button>
                        
                        <div class="flex items-center space-x-2 border-l border-slate-800 pl-4">
                            <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white font-bold flex items-center justify-center text-xs shadow shadow-indigo-500/20 uppercase">
                                {{ substr(Auth::user()->name, 0, 2) }}
                            </div>
                            <span class="text-xs font-semibold text-slate-300 hidden md:inline">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                </header>

                <!-- Page Content Area -->
                <main class="flex-1 overflow-y-auto px-8 py-6 bg-[#0c0d12]">
                    <!-- Flash Message Banners inside Glassmorphism wrapper -->
                    <div class="max-w-7xl mx-auto mb-4">
                        @if (session('success'))
                            <div class="mb-4 bg-emerald-950/40 border border-emerald-500/30 p-4 rounded-xl shadow-md shadow-emerald-950/10 flex items-center justify-between transition duration-150 animate-fadeIn">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-emerald-400 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-emerald-300 text-sm font-semibold">{{ session('success') }}</span>
                                </div>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-4 bg-rose-950/40 border border-rose-500/30 p-4 rounded-xl shadow-md shadow-rose-950/10 flex items-center justify-between transition duration-150 animate-fadeIn">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-rose-400 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-rose-300 text-sm font-semibold">{{ session('error') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Real-time top bar clock ticker -->
        <script>
            setInterval(() => {
                const headerClock = document.getElementById('header-realtime-clock');
                if (headerClock) {
                    const d = new Date();
                    headerClock.innerText = d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
                }
            }, 1000);
        </script>
    </body>
</html>
