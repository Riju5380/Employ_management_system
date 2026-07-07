<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Account Settings') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0c0d12] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Profile Info Form Panel -->
            <div class="p-6 sm:p-8 bg-[#13151c] border border-white/5 sm:rounded-2xl shadow-xl text-slate-100">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Form Panel -->
            <div class="p-6 sm:p-8 bg-[#13151c] border border-white/5 sm:rounded-2xl shadow-xl text-slate-100">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Panel -->
            <div class="p-6 sm:p-8 bg-[#13151c] border border-white/5 sm:rounded-2xl shadow-xl text-slate-100">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
