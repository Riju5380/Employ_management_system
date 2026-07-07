<x-guest-layout>
    <!-- Header/Introduction -->
    <div class="mb-4 text-slate-400 font-semibold text-xs text-center">
        Create a new Administrator account for the Chronos HR system.
    </div>

    <form method="POST" action="{{ route('admin.register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Full Name</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </span>
                <input id="name" type="text" name="name" :value="old('name')" required autofocus placeholder="John Doe" 
                    class="block w-full pl-11 pr-4 py-3 bg-[#0c0d12] border border-[#1f222e] rounded-xl text-sm text-slate-100 placeholder-slate-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-rose-500" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Work Email</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </span>
                <input id="email" type="email" name="email" :value="old('email')" required placeholder="admin@company.com" 
                    class="block w-full pl-11 pr-4 py-3 bg-[#0c0d12] border border-[#1f222e] rounded-xl text-sm text-slate-100 placeholder-slate-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-500" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Password</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
                <input id="password" type="password" name="password" required placeholder="••••••••" 
                    class="block w-full pl-11 pr-4 py-3 bg-[#0c0d12] border border-[#1f222e] rounded-xl text-sm text-slate-100 placeholder-slate-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-rose-500" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Confirm Password</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
                <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••" 
                    class="block w-full pl-11 pr-4 py-3 bg-[#0c0d12] border border-[#1f222e] rounded-xl text-sm text-slate-100 placeholder-slate-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-rose-500" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-500 hover:to-indigo-600 text-white font-bold text-sm rounded-xl transition duration-150 shadow-lg shadow-indigo-600/20 flex items-center justify-center space-x-2">
                <span>Register Admin</span>
                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
    </form>

    <!-- Go Back Link -->
    <div class="mt-6 text-center text-xxs text-slate-500 font-semibold">
        Already have an admin account? <a class="text-indigo-400 hover:underline font-bold" href="{{ route('login') }}">Back to Login</a>
    </div>
</x-guest-layout>
