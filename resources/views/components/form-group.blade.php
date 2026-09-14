@props([
    'label' => null,
    'name' => null,
    'required' => false,
    'help' => null,
    'error' => null,
])

@php
    $errorMessage = $error ?? ($name ? $errors->first($name) : null);
@endphp

<div {{ $attributes->merge(['class' => 'space-y-1.5']) }}>
    @if ($label)
        <label for="{{ $name }}" class="block text-xs font-semibold uppercase tracking-wider text-slate-700">
            {{ $label }}
            @if ($required)
                <span class="text-rose-500 font-bold ml-0.5">*</span>
            @endif
        </label>
    @endif

    {{ $slot }}

    @if ($help && !$errorMessage)
        <p class="text-xs text-slate-500 mt-1">{{ $help }}</p>
    @endif

    @if ($errorMessage)
        <p class="text-xs text-rose-600 font-medium mt-1 flex items-center gap-1">
            <svg class="w-3.5 h-3.5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ $errorMessage }}</span>
        </p>
    @endif
</div>
