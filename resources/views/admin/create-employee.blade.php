<x-app-layout>
    <div class="max-w-md mx-auto space-y-6 text-slate-100 pb-12">
        
        <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl">
            <h2 class="text-lg font-extrabold text-white flex items-center mb-2">
                <svg class="h-6 w-6 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Register New Employee
            </h2>
            <span class="text-xxs text-slate-500 font-bold uppercase tracking-widest">Assign credentials and roles for a new staff member</span>
        </div>

        <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl">
            <form action="{{ route('admin.employees.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Full Name</label>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus placeholder="John Doe" 
                        class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white placeholder-slate-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none px-4 py-3 transition duration-150">
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-rose-500" />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Work Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required placeholder="john@company.com" 
                        class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white placeholder-slate-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none px-4 py-3 transition duration-150">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-500" />
                </div>

                <!-- Position & Department -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="department" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Department</label>
                        <select name="department" id="department" required 
                            class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none px-4 py-3 transition duration-150">
                            <option value="Engineering">Engineering</option>
                            <option value="Design">Design</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Support">Support</option>
                            <option value="Operations">Operations</option>
                        </select>
                        <x-input-error :messages="$errors->get('department')" class="mt-1 text-xs text-rose-500" />
                    </div>
                    <div>
                        <label for="position" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Job Position</label>
                        <input id="position" type="text" name="position" required placeholder="Senior Developer" 
                            class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white placeholder-slate-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none px-4 py-3 transition duration-150">
                        <x-input-error :messages="$errors->get('position')" class="mt-1 text-xs text-rose-500" />
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Temporary Password</label>
                    <input id="password" type="password" name="password" required placeholder="••••••••" 
                        class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white placeholder-slate-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none px-4 py-3 transition duration-150">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-rose-500" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Confirm Temporary Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••" 
                        class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white placeholder-slate-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none px-4 py-3 transition duration-150">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-rose-500" />
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-2 pt-4 border-t border-[#1f222e]">
                    <a href="{{ route('admin.employees') }}" class="px-4 py-2.5 bg-[#1d1f27] hover:bg-[#252834] text-slate-300 font-semibold rounded-xl text-sm border border-[#2e3347] transition duration-150">Cancel</a>
                    <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition duration-150 shadow shadow-indigo-600/15">Register Employee</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
