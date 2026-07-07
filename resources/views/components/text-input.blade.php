@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-[#0c0d12] border-[#1f222e] text-slate-100 placeholder-slate-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm py-3 px-4 transition duration-150']) }}>
