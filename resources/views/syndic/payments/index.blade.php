<x-syndic-layout>
    <x-slot name="header">Gestion des Paiements & Cotisations</x-slot>

    <!-- Success Flash Alert -->
    @if (session('success'))
        <x-alert type="success" title="Succès !" dismissible>
            {{ session('success') }}
        </x-alert>
    @endif

    <!-- Page Header Title & Primary Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Liste des Cotisations Enregistrées</h2>
            <p class="text-xs text-slate-500 mt-0.5">Suivi en temps réel des encaissements, des relances et des reçus de la résidence</p>
        </div>
        <div class="shrink-0 flex items-center gap-3">
            <a href="{{ route('syndic.payments.create') }}">
                <x-button variant="primary" size="md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nouveau Paiement
                </x-button>
            </a>
        </div>
    </div>

    <!-- Search & Filter Controls Bar -->
    <x-card padding>
        <form method="GET" action="{{ route('syndic.payments.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search Keyword -->
            <x-input
                name="search"
                placeholder="Rechercher par résident, N° appt..."
                value="{{ request('search') }}"
                icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>'
            />

            <!-- Filter Status -->
            <select name="status" onchange="this.form.submit()" class="w-full rounded-xl text-sm border-slate-200 focus:border-brand-500 focus:ring-brand-500/20 py-2.5 px-3 bg-white shadow-xs">
                <option value="">Tous les statuts</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Payé (Confirmé)</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente de validation</option>
                <option value="late" {{ request('status') === 'late' ? 'selected' : '' }}>En retard / Impayé</option>
            </select>

            <!-- Filter Building -->
            <select name="building" onchange="this.form.submit()" class="w-full rounded-xl text-sm border-slate-200 focus:border-brand-500 focus:ring-brand-500/20 py-2.5 px-3 bg-white shadow-xs">
                <option value="">Tous les Bâtiments</option>
                @foreach ($buildings as $b)
                    <option value="{{ $b->id }}" {{ request('building') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                @endforeach
            </select>

            <!-- Filter Month -->
            <select name="month" onchange="this.form.submit()" class="w-full rounded-xl text-sm border-slate-200 focus:border-brand-500 focus:ring-brand-500/20 py-2.5 px-3 bg-white shadow-xs">
                <option value="">Tous les mois</option>
                <option value="2026-09" {{ request('month') === '2026-09' ? 'selected' : '' }}>Septembre 2026</option>
                <option value="2026-08" {{ request('month') === '2026-08' ? 'selected' : '' }}>Août 2026</option>
                <option value="2026-07" {{ request('month') === '2026-07' ? 'selected' : '' }}>Juillet 2026</option>
            </select>
        </form>
    </x-card>

    <!-- Main List Table Component -->
    <x-card padding={false}>
        <x-table :headers="['Copropriétaire', 'Appartement', 'Période', 'Montant', 'Mode', 'Date', 'Statut', 'Actions']" :empty="$payments->isEmpty()">
            @foreach ($payments as $payment)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 font-bold flex items-center justify-center text-xs">
                                {{ strtoupper(substr(optional($payment->payer)->name ?? 'U', 0, 2)) }}
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block">{{ optional($payment->payer)->name ?? 'Copropriétaire' }}</span>
                                <span class="text-[10px] text-slate-400">{{ optional($payment->payer)->email ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-slate-700">Appt {{ optional($payment->apartment)->number }} ({{ optional(optional($payment->apartment)->building)->name }})</td>
                    <td class="px-6 py-4 text-slate-600">{{ $payment->month }}</td>
                    <td class="px-6 py-4 font-extrabold text-slate-900">{{ number_format($payment->amount, 2, ',', ' ') }} DH</td>
                    <td class="px-6 py-4 text-slate-600">{{ ucfirst($payment->payment_method) }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ optional($payment->payment_date)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        @if ($payment->status === 'paid')
                            <x-badge variant="success" dot>Payé</x-badge>
                        @elseif ($payment->status === 'pending')
                            <x-badge variant="warning" dot>En attente</x-badge>
                        @else
                            <x-badge variant="danger" dot>En retard</x-badge>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('syndic.payments.receipt', $payment->id) }}" title="Télécharger reçu PDF" class="p-1.5 text-brand-600 hover:bg-brand-50 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-table>

        <div class="p-4 border-t border-slate-100">
            {{ $payments->links() }}
        </div>
    </x-card>
</x-syndic-layout>
