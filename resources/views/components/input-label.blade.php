@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-xxs text-slate-400 uppercase tracking-wider mb-1.5']) }}>
    {{ $value ?? $slot }}
</label>
