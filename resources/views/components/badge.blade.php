@props([
    'variant' => 'info', // success, warning, danger, info, neutral, primary
    'size' => 'md', // sm, md
    'dot' => false,
])

@php
    $sizeClasses = [
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-1 text-xs font-medium',
    ][$size] ?? 'px-2.5 py-1 text-xs font-medium';

    $variantClasses = [
        'success' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20',
        'warning' => 'bg-amber-50 text-amber-800 ring-1 ring-inset ring-amber-600/20',
        'danger' => 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/20',
        'info' => 'bg-sky-50 text-sky-700 ring-1 ring-inset ring-sky-600/20',
        'primary' => 'bg-brand-50 text-brand-700 ring-1 ring-inset ring-brand-600/20',
        'neutral' => 'bg-slate-100 text-slate-700 ring-1 ring-inset ring-slate-500/10',
    ][$variant] ?? 'bg-slate-100 text-slate-700 ring-1 ring-inset ring-slate-500/10';

    $dotColors = [
        'success' => 'bg-emerald-500',
        'warning' => 'bg-amber-500',
        'danger' => 'bg-rose-500',
        'info' => 'bg-sky-500',
        'primary' => 'bg-brand-500',
        'neutral' => 'bg-slate-400',
    ][$variant] ?? 'bg-slate-400';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full tracking-wide {$sizeClasses} {$variantClasses}"]) }}>
    @if ($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColors }}"></span>
    @endif
    <span>{{ $slot }}</span>
</span>
