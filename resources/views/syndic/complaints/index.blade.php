<x-syndic-layout>
    <x-slot name="header">Gestion des Réclamations Résidence</x-slot>

    @if (session('success'))
        <x-alert type="success" title="Succès !" dismissible>{{ session('success') }}</x-alert>
    @endif

    <!-- Page Header & Stats Summary -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                Réclamations des habitants
            </h2>
            <p class="text-xs text-slate-500 mt-1">Consultez et traitez l'ensemble des réclamations transmises par les copropriétaires</p>
        </div>
    </div>

    <!-- Status Filter Badges/Tabs -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-2 overflow-x-auto pb-2 custom-scrollbar">
            <a href="{{ route('syndic.complaints') }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold transition border {{ !request('status') ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-600 border-slate-200 hover:border-slate-300' }}">
                Toutes ({{ $counts['total'] }})
            </a>
            <a href="{{ route('syndic.complaints', ['status' => 'déposée']) }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold transition border {{ request('status') === 'déposée' ? 'bg-sky-600 text-white border-sky-600' : 'bg-white text-sky-700 border-slate-200 hover:border-sky-300' }}">
                Déposées ({{ $counts['déposée'] }})
            </a>
            <a href="{{ route('syndic.complaints', ['status' => 'en_attente']) }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold transition border {{ request('status') === 'en_attente' ? 'bg-amber-600 text-white border-amber-600' : 'bg-white text-amber-700 border-slate-200 hover:border-amber-300' }}">
                En attente ({{ $counts['en_attente'] }})
            </a>
            <a href="{{ route('syndic.complaints', ['status' => 'avec_succès']) }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold transition border {{ request('status') === 'avec_succès' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-emerald-700 border-slate-200 hover:border-emerald-300' }}">
                Avec succès ({{ $counts['avec_succès'] }})
            </a>
            <a href="{{ route('syndic.complaints', ['status' => 'refusée']) }}" class="px-3.5 py-2 rounded-xl text-xs font-semibold transition border {{ request('status') === 'refusée' ? 'bg-rose-600 text-white border-rose-600' : 'bg-white text-rose-700 border-slate-200 hover:border-rose-300' }}">
                Refusées ({{ $counts['refusée'] }})
            </a>
        </div>

        <!-- Search input -->
        <form method="GET" action="{{ route('syndic.complaints') }}" class="flex items-center gap-2">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher ticket, habitant..." class="rounded-xl text-xs border-slate-200 py-2 px-3 focus:border-brand-500 focus:ring-brand-500/20 w-56">
            <x-button variant="outline" size="sm" type="submit">Filtrer</x-button>
        </form>
    </div>

    <!-- Complaints Table / List -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4">Ticket</th>
                        <th class="py-3.5 px-4">Habitant / Logement</th>
                        <th class="py-3.5 px-4">Description</th>
                        <th class="py-3.5 px-4">Date de dépôt</th>
                        <th class="py-3.5 px-4">Statut actuel</th>
                        <th class="py-3.5 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($complaints as $complaint)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-4 font-mono font-bold text-slate-900">
                                #{{ $complaint->ticket_number }}
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-900">{{ optional($complaint->resident)->name ?? 'Habitant inconnu' }}</div>
                                <div class="text-[11px] text-slate-500">Appt {{ optional($complaint->apartment)->number ?? '-' }} ({{ optional(optional($complaint->apartment)->building)->name ?? '-' }})</div>
                            </td>
                            <td class="py-4 px-4 max-w-xs">
                                @if($complaint->title)
                                    <div class="font-bold text-slate-900 truncate mb-0.5">{{ $complaint->title }}</div>
                                @endif
                                <div class="text-slate-600 line-clamp-2">{{ $complaint->description }}</div>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap text-slate-500">
                                {{ $complaint->created_at->format('d/m/Y à H:i') }}
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <x-badge :variant="$complaint->status_badge_variant" size="sm">
                                    {{ $complaint->status_label }}
                                </x-badge>
                            </td>
                            <td class="py-4 px-4 text-right whitespace-nowrap space-x-1">
                                <a href="{{ route('syndic.complaints.pdf', $complaint->id) }}" target="_blank" title="Télécharger PDF">
                                    <x-button variant="outline" size="sm">
                                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </x-button>
                                </a>
                                <a href="{{ route('syndic.complaints.show', $complaint->id) }}">
                                    <x-button variant="primary" size="sm">
                                        Traiter / Consulter &rarr;
                                    </x-button>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                Aucune réclamation trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $complaints->links() }}
        </div>
    </div>
</x-syndic-layout>
