@props([
    'variant' => 'primary', // primary, secondary, danger, success, outline, ghost
    'size' => 'md', // sm, md, lg
    'type' => 'button',
    'icon' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed cursor-pointer shadow-sm';

    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-xs gap-1.5',
        'md' => 'px-4 py-2 text-sm gap-2',
        'lg' => 'px-6 py-2.5 text-base gap-2.5',
    ][$size] ?? 'px-4 py-2 text-sm gap-2';

    $variantClasses = [
        'primary' => 'bg-brand-600 hover:bg-brand-700 text-white focus:ring-brand-500 shadow-brand-500/20 hover:shadow-md',
        'secondary' => 'bg-slate-800 hover:bg-slate-900 text-white focus:ring-slate-700',
        'danger' => 'bg-rose-600 hover:bg-rose-700 text-white focus:ring-rose-500 shadow-rose-500/20',
        'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white focus:ring-emerald-500 shadow-emerald-500/20',
        'outline' => 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 hover:text-slate-900 focus:ring-brand-500',
        'ghost' => 'bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900 focus:ring-slate-400 shadow-none',
    ][$variant] ?? 'bg-brand-600 hover:bg-brand-700 text-white focus:ring-brand-500';

    $classes = "{$baseClasses} {$sizeClasses} {$variantClasses}";
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => $classes]) }}>
    @if ($icon)
        <span class="shrink-0">{!! $icon !!}</span>
    @endif
    <span>{{ $slot }}</span>
</button>
