<x-syndic-layout>
    <x-slot name="header">Tableau de Bord Syndic</x-slot>

    <!-- Welcome Alert Banner -->
    <x-alert type="info" title="Bienvenue sur SyndicManager !" dismissible>
        Vous avez <strong>{{ $activeComplaintsCount }} réclamations en cours</strong> et <strong>{{ $urgentComplaintsCount }} réclamation(s) urgente(s)</strong> nécessitant votre attention.
    </x-alert>

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Aperçu Général des Activités</h2>
            <p class="text-xs text-slate-500">Statistiques financières et tickets d'incidents de la résidence</p>
        </div>
        <a href="{{ route('syndic.dashboard.pdf') }}">
            <x-button variant="outline" size="sm" class="flex items-center gap-1.5 bg-white shadow-xs">
                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Télécharger Rapport PDF
            </x-button>
        </a>
    </div>

    <!-- KPI Statistic Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Encaissé ce mois -->
        <x-card hover class="relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Encaissé (Mois en cours)</span>
                    <span class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ number_format($totalCollectedThisMonth, 2, ',', ' ') }} <span class="text-xs font-semibold text-slate-500">DH</span></span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold shadow-emerald-500/10 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-emerald-600 font-semibold flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Statistiques temps réel Eloquent
                </span>
            </div>
        </x-card>

        <!-- Card 2: Impayés Estimés -->
        <x-card hover class="relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Total Impayés / Attente</span>
                    <span class="text-2xl font-extrabold text-rose-600 tracking-tight">{{ number_format($totalUnpaid, 2, ',', ' ') }} <span class="text-xs font-semibold text-slate-500">DH</span></span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold shadow-rose-500/10 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500">Cotisations en attente de relance</span>
            </div>
        </x-card>

        <!-- Card 3: Réclamations Actives -->
        <x-card hover class="relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Réclamations</span>
                    <span class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $activeComplaintsCount }} <span class="text-xs font-semibold text-amber-600 font-bold">En cours</span></span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold shadow-amber-500/10 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-amber-600 font-medium">{{ $urgentComplaintsCount }} urgente(s)</span>
            </div>
        </x-card>

        <!-- Card 4: Nombre Résidents -->
        <x-card hover class="relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Occupation</span>
                    <span class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $occupiedApartmentsCount }} / {{ $totalApartmentsCount }} <span class="text-xs font-semibold text-slate-500">Appts</span></span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center font-bold shadow-brand-500/10 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500">Appartements occupés</span>
            </div>
        </x-card>
    </div>

    <!-- Main Content Layout (Table + Side Feed) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Payments Table (2 Columns) -->
        <div class="lg:col-span-2 space-y-6">
            <x-card title="Derniers Paiements Enregistrés" subtitle="Historique récent des encaissements de cotisations">
                <x-slot name="action">
                    <a href="{{ route('syndic.payments.create') }}">
                        <x-button variant="primary" size="sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Ajouter Paiement
                        </x-button>
                    </a>
                </x-slot>

                <x-table :headers="['Copropriétaire', 'Appartement', 'Mois', 'Montant', 'Statut', 'Reçu PDF']" :empty="$recentPayments->isEmpty()">
                    @foreach ($recentPayments as $payment)
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ optional($payment->payer)->name ?? 'Copropriétaire' }}</td>
                            <td class="px-6 py-4 text-slate-600">Appt {{ optional($payment->apartment)->number }} ({{ optional(optional($payment->apartment)->building)->name }})</td>
                            <td class="px-6 py-4 text-slate-600">{{ $payment->month }}</td>
                            <td class="px-6 py-4 font-bold text-slate-900">{{ number_format($payment->amount, 2, ',', ' ') }} DH</td>
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
                                <a href="{{ route('syndic.payments.receipt', $payment->id) }}" class="text-brand-600 hover:text-brand-800 font-medium text-xs flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Reçu PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
                
                <x-slot name="footer">
                    <span>Affichage des paiements récents</span>
                    <a href="{{ route('syndic.payments.index') }}" class="text-brand-600 font-semibold hover:underline">Voir tous les paiements &rarr;</a>
                </x-slot>
            </x-card>
        </div>

        <!-- Right Side Column: Pending Complaints & Announcements -->
        <div class="space-y-6">
            <!-- Pending Complaints Widget -->
            <x-card title="Réclamations Récentes" subtitle="Demandes nécessitant une réponse">
                <div class="space-y-4">
                    @forelse ($recentComplaints as $complaint)
                        <a href="{{ route('syndic.complaints.show', $complaint->id) }}" class="block p-3.5 rounded-xl border border-slate-100 hover:border-brand-300 hover:bg-brand-50/30 transition group">
                            <div class="flex items-center justify-between mb-1">
                                <x-badge :variant="$complaint->priority === 'urgent' ? 'danger' : ($complaint->priority === 'high' ? 'warning' : 'info')" size="sm">
                                    {{ ucfirst($complaint->priority) }}
                                </x-badge>
                                <span class="text-[10px] text-slate-400">{{ $complaint->created_at->diffForHumans() }}</span>
                            </div>
                            <h4 class="text-sm font-semibold text-slate-900 group-hover:text-brand-600 transition">{{ $complaint->title }}</h4>
                            <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">Signalé par {{ optional($complaint->resident)->name }} (Appt {{ optional($complaint->apartment)->number }})</p>
                        </a>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">Aucune réclamation ouverte.</p>
                    @endforelse
                </div>
            </x-card>

            <!-- Latest Announcement Widget -->
            <x-card title="Dernière Annonce Publiée">
                @if ($latestAnnouncement)
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                        <div class="flex items-center gap-2 text-xs font-bold text-brand-600 mb-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
                            <span>{{ $latestAnnouncement->title }}</span>
                        </div>
                        <p class="text-xs text-slate-600 mt-1">{{ $latestAnnouncement->content }}</p>
                        <span class="text-[10px] text-slate-400 mt-2 block">Publié le {{ optional($latestAnnouncement->published_at)->format('d/m/Y') }}</span>
                    </div>
                @else
                    <p class="text-xs text-slate-400 text-center py-4">Aucune annonce publiée.</p>
                @endif
            </x-card>
        </div>
    </div>
</x-syndic-layout>
