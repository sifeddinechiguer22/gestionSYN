@props([
    'currentPage' => 1,
    'totalPages' => 5,
    'totalItems' => 48,
    'perPage' => 10,
])

<div class="px-6 py-4 bg-white border-t border-slate-100 flex items-center justify-between gap-4 rounded-b-2xl">
    <div class="text-xs text-slate-500 font-medium">
        Affichage de <span class="font-bold text-slate-800">{{ (($currentPage - 1) * $perPage) + 1 }}</span> à <span class="font-bold text-slate-800">{{ min($currentPage * $perPage, $totalItems) }}</span> sur <span class="font-bold text-slate-800">{{ $totalItems }}</span> résultats
    </div>

    <div class="flex items-center gap-1.5">
        <!-- Previous Page -->
        <button 
            type="button" 
            {{ $currentPage <= 1 ? 'disabled' : '' }}
            class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed transition flex items-center gap-1"
        >
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Précédent</span>
        </button>

        <!-- Page Numbers -->
        @for ($i = 1; $i <= $totalPages; $i++)
            <button 
                type="button" 
                class="w-8 h-8 rounded-lg text-xs font-semibold transition flex items-center justify-center {{ $i === $currentPage ? 'bg-brand-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}"
            >
                {{ $i }}
            </button>
        @endfor

        <!-- Next Page -->
        <button 
            type="button" 
            {{ $currentPage >= $totalPages ? 'disabled' : '' }}
            class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed transition flex items-center gap-1"
        >
            <span>Suivant</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</div>
