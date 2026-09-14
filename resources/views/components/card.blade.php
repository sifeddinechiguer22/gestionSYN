@props([
    'title' => null,
    'subtitle' => null,
    'action' => null,
    'footer' => null,
    'padding' => true,
    'hover' => false,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-slate-100 shadow-card transition-all duration-300 ' . ($hover ? 'hover:shadow-card-hover hover:-translate-y-0.5' : '')]) }}>
    @if ($title || $subtitle || $action)
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between gap-4">
            <div>
                @if ($title)
                    <h3 class="text-base font-semibold text-slate-900 tracking-tight">{{ $title }}</h3>
                @endif
                @if ($subtitle)
                    <p class="text-xs text-slate-500 mt-0.5">{{ $subtitle }}</p>
                @endif
            </div>
            @if ($action)
                <div class="shrink-0 flex items-center gap-2">
                    {{ $action }}
                </div>
            @endif
        </div>
    @endif

    <div class="{{ $padding ? 'p-6' : '' }}">
        {{ $slot }}
    </div>

    @if ($footer)
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 rounded-b-2xl flex items-center justify-between text-sm text-slate-600">
            {{ $footer }}
        </div>
    @endif
</div>
