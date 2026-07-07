<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-emerald-400 font-semibold text-xs text-center" :status="session('status')" />

    <!-- Alpine.js dynamic role selector -->
    <div x-data="{ tab: 'employee' }" class="space-y-6">
        
        <!-- Tab Buttons (Mockup Selector) -->
        <div class="grid grid-cols-2 gap-2 bg-[#0c0d12] p-1 rounded-xl border border-white/5">
            <button type="button" @click="tab = 'employee'" 
                :class="tab === 'employee' ? 'bg-[#1f222e] text-white shadow' : 'text-slate-500 hover:text-slate-300'"
                class="py-2 text-xxs font-extrabold uppercase tracking-wider rounded-lg transition duration-150">
                Employee Login
            </button>
            <button type="button" @click="tab = 'admin'" 
                :class="tab === 'admin' ? 'bg-[#1f222e] text-white shadow' : 'text-slate-500 hover:text-slate-300'"
                class="py-2 text-xxs font-extrabold uppercase tracking-wider rounded-lg transition duration-150">
                Admin Login
            </button>
        </div>

        <!-- Single Form for both tab logins (same fields, dynamic helpers) -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                    <span x-show="tab === 'employee'">Work Email</span>
                    <span x-show="tab === 'admin'">Admin Email</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-500">
                        <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                        :placeholder="tab === 'employee' ? 'name@company.com' : 'admin@company.com'" 
                        class="block w-full pl-11 pr-4 py-3 bg-[#0c0d12] border border-[#1f222e] rounded-xl text-sm text-slate-100 placeholder-slate-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-500" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label for="password" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider">Password</label>
                    @if (Route::has('password.request'))
                        <a class="text-3xs font-semibold text-indigo-400 hover:text-indigo-300" href="{{ route('password.request') }}">
                            Forgot?
                        </a>
                    @endif
                </div>
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

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember" 
                    class="rounded bg-[#0c0d12] border-[#1f222e] text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-[#13151c] h-4 w-4">
                <span class="ms-2 text-xs font-semibold text-slate-400">{{ __('Remember this device') }}</span>
            </div>

            <!-- Login Button -->
            <div class="pt-2">
                <button type="submit" class="w-full py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-500 hover:to-indigo-600 text-white font-bold text-sm rounded-xl transition duration-150 shadow-lg shadow-indigo-600/20 flex items-center justify-center space-x-2">
                    <span x-show="tab === 'employee'">Login as Employee</span>
                    <span x-show="tab === 'admin'">Login as Administrator</span>
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>

        <!-- Temporary first-time Admin register option (Only shown on Admin Tab) -->
        <div x-show="tab === 'admin'" class="mt-6 text-center text-xxs text-slate-500 font-semibold" style="display: none;" x-transition>
            First time setting up? <a class="text-indigo-400 hover:underline font-bold" href="{{ route('admin.register') }}">Register Admin Account</a>
        </div>

        <div x-show="tab === 'employee'" class="mt-6 text-center text-xxs text-slate-500 font-semibold" x-transition>
            Don't have an account? <span class="text-indigo-500">Contact HR Admin</span>
        </div>
    </div>
</x-guest-layout>
