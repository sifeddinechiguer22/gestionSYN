@props([
    'headers' => [],
    'empty' => false,
    'emptyMessage' => 'Aucune donnée disponible pour le moment.',
])

<div class="overflow-x-auto rounded-2xl border border-slate-100 bg-white shadow-card">
    <table {{ $attributes->merge(['class' => 'w-full text-left text-sm text-slate-600']) }}>
        @if (count($headers) > 0)
            <thead class="bg-slate-50/80 border-b border-slate-100 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                <tr>
                    @foreach ($headers as $header)
                        <th scope="col" class="px-6 py-3.5">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody class="divide-y divide-slate-100">
            @if ($empty)
                <tr>
                    <td colspan="{{ max(count($headers), 1) }}" class="px-6 py-12 text-center text-slate-400">
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <svg class="w-10 h-10 text-slate-300 stroke-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="text-sm font-medium">{{ $emptyMessage }}</p>
                        </div>
                    </td>
                </tr>
            @else
                {{ $slot }}
            @endif
        </tbody>
    </table>
</div>
