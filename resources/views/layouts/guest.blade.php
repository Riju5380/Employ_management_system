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
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#0c0d12] relative overflow-hidden">
            
            <!-- Dynamic Glowing Orbs in Background -->
            <div class="absolute top-1/4 left-1/4 h-72 w-72 rounded-full bg-indigo-500/10 blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-1/4 right-1/4 h-80 w-80 rounded-full bg-purple-500/10 blur-[130px] pointer-events-none"></div>

            <!-- Login Center Glass Panel Card -->
            <div class="w-full sm:max-w-md px-8 py-10 bg-[#13151c]/90 border border-white/5 backdrop-blur-xl shadow-2xl rounded-2xl z-10 flex flex-col items-center">
                
                <!-- Logo & Heading -->
                <div class="flex flex-col items-center mb-8">
                    <div class="h-14 w-14 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-indigo-600/30 mb-4">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-extrabold text-white tracking-wide uppercase text-center">Chronos HR</h2>
                    <span class="text-xxs text-indigo-400 font-bold uppercase tracking-widest mt-1">Attendance Management</span>
                </div>

                <!-- Main Slot -->
                <div class="w-full">
                    {{ $slot }}
                </div>

                <!-- Footer details -->
                <div class="mt-8 flex items-center space-x-2 text-4xs text-slate-500 font-bold uppercase tracking-widest">
                    <span>&bull; Systems Active</span>
                    <span>v2.4.0 Stable</span>
                </div>
            </div>
        </div>
    </body>
</html>
