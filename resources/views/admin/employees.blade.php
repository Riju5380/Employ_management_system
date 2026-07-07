<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6 text-slate-100 pb-12">
        
        <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl">
            <div>
                <span class="text-4xs text-slate-500 font-extrabold uppercase tracking-widest block">HR Database</span>
                <h1 class="text-2xl font-black text-white mt-1 tracking-tight">Employee Database</h1>
            </div>
        </div>

        <div class="bg-[#13151c] p-6 rounded-2xl border border-white/5 shadow-xl">
            <h2 class="text-md font-extrabold text-white mb-6 flex justify-between items-center">
                <span class="flex items-center space-x-2">
                    <span>Registered Employee Directory</span>
                    <span class="text-xs bg-indigo-500/10 text-indigo-400 font-semibold px-2.5 py-1 rounded-full border border-indigo-500/15">{{ $employees->total() }} Employees</span>
                </span>
                <a href="{{ route('admin.employees.create') }}" class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl transition duration-150 shadow-md shadow-indigo-600/15">
                    + Add Employee
                </a>
            </h2>

            <div class="overflow-x-auto">
                <table class="min-w-full text-slate-300 text-sm">
                    <thead>
                        <tr class="text-left text-xxs font-bold text-slate-500 uppercase tracking-widest border-b border-[#1f222e]">
                            <th class="px-6 py-3">Employee Name</th>
                            <th class="px-6 py-3">Email Address</th>
                            <th class="px-6 py-3">Department</th>
                            <th class="px-6 py-3">Job Position</th>
                            <th class="px-6 py-3 text-right">Activity Audit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1f222e]/45">
                        @foreach($employees as $emp)
                            <tr class="hover:bg-white/5 transition duration-150">
                                <td class="px-6 py-4 font-bold text-white flex items-center space-x-3">
                                    <div class="h-8 w-8 bg-indigo-500/10 text-indigo-400 font-bold rounded-xl flex items-center justify-center text-xs uppercase border border-indigo-500/15 shadow-sm shadow-indigo-500/5">
                                        {{ substr($emp->name, 0, 2) }}
                                    </div>
                                    <span>{{ $emp->name }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-400 text-xs font-semibold">{{ $emp->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-4xs font-bold uppercase tracking-widest bg-slate-800 text-slate-400 border border-slate-700/30">
                                        {{ $emp->department ?? 'Unassigned' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-300 text-xs">{{ $emp->position ?? 'Unassigned' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.attendance', ['user_id' => $emp->id]) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600/10 hover:bg-indigo-600/20 border border-indigo-500/25 text-indigo-400 font-bold text-xxs tracking-wider uppercase rounded-xl transition duration-150">
                                        Audit Logs
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
