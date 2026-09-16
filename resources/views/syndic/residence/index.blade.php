<x-syndic-layout>
    <x-slot name="header">Fiche Signalétique de la Résidence</x-slot>

    <div class="space-y-6">
        <!-- Hero Header Card -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-slate-800 to-brand-950 p-6 lg:p-8 text-white shadow-xl">
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-brand-500/20 text-brand-300 border border-brand-500/30 inline-block mb-2">Copropriété Active</span>
                        <h2 class="text-2xl font-extrabold tracking-tight">{{ $residence?->name ?? 'Aucune résidence enregistrée' }}</h2>
                    <p class="text-slate-300 text-sm mt-1 flex items-center gap-2">
                        <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        @if ($residence)
                            {{ $residence->address }}, {{ $residence->city }} ({{ $residence->postal_code }})
                        @else
                            Les informations de la résidence seront affichées après sa création.
                        @endif
                    </p>
                </div>
                <div class="shrink-0 flex items-center gap-3">
                    <x-badge variant="neutral" size="md">Aucun gestionnaire configuré</x-badge>
                </div>
            </div>
        </div>

        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <x-card hover>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Nombre de Bâtiments</span>
                <span class="text-2xl font-extrabold text-slate-900">{{ $buildingsCount }} <span class="text-xs text-slate-500 font-normal">Blocs</span></span>
            </x-card>

            <x-card hover>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Total Appartements</span>
                <span class="text-2xl font-extrabold text-slate-900">{{ $apartmentsCount }} <span class="text-xs text-slate-500 font-normal">Lots</span></span>
            </x-card>

            <x-card hover>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Logements Occupés</span>
                <span class="text-2xl font-extrabold text-emerald-600">{{ $occupiedCount }}</span>
            </x-card>

            <x-card hover>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Logements Vacants</span>
                <span class="text-2xl font-extrabold text-amber-600">{{ $vacantCount }}</span>
            </x-card>
        </div>

        <!-- Buildings List -->
        <x-card title="Bâtiments & Immeubles de la Résidence" subtitle="Vue synthétique des blocs composants la copropriété">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @if ($residence)
                    @foreach ($residence->buildings as $building)
                    <div class="p-5 rounded-2xl border border-slate-200 bg-white hover:shadow-card transition space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="font-extrabold text-base text-slate-900">{{ $building->name }}</h4>
                            <x-badge variant="neutral" size="sm">{{ $building->code }}</x-badge>
                        </div>
                        <div class="space-y-1.5 text-xs text-slate-600">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Étages :</span>
                                <span class="font-bold">{{ $building->floors_count }} étages</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Appartements :</span>
                                <span class="font-bold">{{ $building->apartments->count() }} appts</span>
                            </div>
                        </div>
                        <a href="{{ route('syndic.apartments') }}?building={{ $building->id }}" class="block text-center pt-2">
                            <x-button variant="outline" size="sm" class="w-full">Voir les appartements &rarr;</x-button>
                        </a>
                    </div>
                    @endforeach
                @else
                    <p class="md:col-span-3 text-center text-sm text-slate-400 py-8">Aucun bâtiment enregistré.</p>
                @endif
            </div>
        </x-card>
    </div>
</x-syndic-layout>
