<x-app-layout>
    <div class="max-w-md mx-auto space-y-6 text-slate-100 pb-12">
        <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl">
            <h2 class="text-lg font-extrabold text-white mb-6 flex items-center">
                <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Leave Application
            </h2>

            <form action="{{ route('leaves.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="leave_type" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">Leave Type</label>
                    <select name="leave_type" id="leave_type" required class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none px-4 py-3 transition duration-150">
                        <option value="sick">Sick Leave</option>
                        <option value="casual">Casual Leave</option>
                        <option value="annual">Annual Leave</option>
                        <option value="unpaid">Unpaid Leave</option>
                    </select>
                </div>

                <div>
                    <label for="from_date" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">From Date</label>
                    <input type="date" name="from_date" id="from_date" required class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none p-3 transition duration-150">
                </div>

                <div>
                    <label for="to_date" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">To Date</label>
                    <input type="date" name="to_date" id="to_date" required class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none p-3 transition duration-150">
                </div>

                <div>
                    <label for="reason" class="block text-xxs font-bold text-slate-400 uppercase tracking-wider mb-2">Reason for Leave</label>
                    <textarea name="reason" id="reason" rows="4" required placeholder="Please describe the reason for your leave request..."
                        class="w-full text-sm bg-[#0c0d12] border border-[#1f222e] rounded-xl text-white placeholder-slate-600 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none p-3.5 transition duration-150"></textarea>
                </div>

                <div class="flex items-center justify-end space-x-2 pt-4 border-t border-[#1f222e]">
                    <a href="{{ route('leaves.index') }}" class="px-4 py-2 bg-[#1d1f27] hover:bg-[#252834] text-slate-300 font-semibold rounded-xl text-sm border border-[#2e3347] transition duration-150">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition duration-150 shadow shadow-indigo-600/15">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
