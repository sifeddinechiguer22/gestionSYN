@props([
    'disabled' => false,
    'error' => null,
    'name' => null,
    'type' => 'text',
    'placeholder' => '',
    'icon' => null,
])

@php
    $hasError = !empty($error) || ($name && $errors->has($name));
    
    $baseClasses = 'w-full rounded-xl text-sm transition-all duration-200 border bg-white focus:outline-none focus:ring-2 disabled:bg-slate-50 disabled:text-slate-500 disabled:cursor-not-allowed shadow-sm';
    
    $paddingClasses = $icon ? 'pl-10 pr-4 py-2.5' : 'px-4 py-2.5';

    $stateClasses = $hasError
        ? 'border-rose-300 text-rose-900 placeholder-rose-300 focus:border-rose-500 focus:ring-rose-500/20'
        : 'border-slate-200 text-slate-900 placeholder-slate-400 focus:border-brand-500 focus:ring-brand-500/20 hover:border-slate-300';
@endphp

<div class="relative rounded-xl">
    @if ($icon)
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
            {!! $icon !!}
        </div>
    @endif

    <input
        {{ $disabled ? 'disabled' : '' }}
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => "{$baseClasses} {$paddingClasses} {$stateClasses}"]) }}
    />
</div>
