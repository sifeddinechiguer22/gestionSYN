<x-resident-layout>
    <x-slot name="header">Mon Espace Résident</x-slot>

    <!-- Welcome Resident Header Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-950 p-6 lg:p-8 text-white shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="space-y-1">
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 inline-block mb-2">Copropriétaire</span>
                <h2 class="text-2xl font-extrabold tracking-tight">Bonjour, {{ Auth::user()->name }} 👋</h2>
                <p class="text-slate-300 text-sm">Bienvenue sur votre portail de copropriété. Retrouvez vos reçus, cotisations et annonces en temps réel.</p>
            </div>
            <div class="shrink-0 flex items-center gap-3">
                <a href="{{ route('resident.complaints') }}">
                    <x-button variant="success" size="md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Nouvelle Réclamation
                    </x-button>
                </a>
            </div>
        </div>
        <!-- Decorative SVG Overlay -->
        <svg class="absolute right-0 bottom-0 opacity-10 w-96 h-96 pointer-events-none transform translate-x-20 translate-y-20" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
    </div>

    <!-- Cards Info Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Apartment Info Card -->
        <x-card title="Mon Appartement" subtitle="Fiche signalétique de votre logement">
            <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500">Numéro Appartement</span>
                    <span class="font-bold text-slate-900">Appt N° {{ optional($apartment)->number ?? '14' }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500">Bâtiment / Étage</span>
                    <span class="font-semibold text-slate-900">{{ optional(optional($apartment)->building)->name ?? 'Bâtiment A' }} — {{ optional($apartment)->floor ?? 3 }}ème Étage</span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500">Superficie</span>
                    <span class="font-semibold text-slate-900">{{ optional($apartment)->area_sqm ?? 115 }} m²</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-slate-500">Cotisation Mensuelle</span>
                    <span class="font-extrabold text-emerald-600">{{ number_format(optional($apartment)->monthly_fee ?? 800, 2, ',', ' ') }} DH / mois</span>
                </div>
            </div>
        </x-card>

        <!-- Payment Status Card -->
        <x-card title="Statut Cotisations" subtitle="Situation financière actuelle">
            <div class="flex flex-col items-center justify-center text-center py-4 space-y-3">
                @if ($isUpToDate)
                    <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-extrabold text-2xl shadow-inner">
                        ✓
                    </div>
                    <div>
                        <x-badge variant="success" size="md" dot>À jour ({{ optional($latestPayment)->month ?? 'Septembre 2026' }})</x-badge>
                        <p class="text-xs text-slate-500 mt-2">Votre cotisation de {{ number_format(optional($latestPayment)->amount ?? 800, 2, ',', ' ') }} DH a été validée le {{ optional(optional($latestPayment)->payment_date)->format('d/m/Y') ?? '05/09/2026' }}.</p>
                    </div>
                    @if ($latestPayment)
                        <a href="{{ route('syndic.payments.receipt', $latestPayment->id) }}" class="w-full">
                            <x-button variant="outline" size="sm" class="w-full">
                                Télécharger le Reçu PDF
                            </x-button>
                        </a>
                    @endif
                @else
                    <div class="w-14 h-14 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-extrabold text-2xl shadow-inner">
                        !
                    </div>
                    <div>
                        <x-badge variant="warning" size="md" dot>Cotisation en attente</x-badge>
                        <p class="text-xs text-slate-500 mt-2">Veuillez régler votre cotisation mensuelle de 800 DH.</p>
                    </div>
                @endif
            </div>
        </x-card>

        <!-- Quick Contacts / Syndic Info -->
        <x-card title="Contact Syndic" subtitle="Interlocuteur de votre résidence">
            <div class="space-y-4 text-sm">
                @if ($syndic)
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-900 text-white font-bold flex items-center justify-center text-xs">
                            {{ strtoupper(substr($syndic->name, 0, 2)) }}
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">{{ $syndic->name }}</span>
                            <span class="text-xs text-slate-500 block">Syndic ({{ $syndic->phone ?? $syndic->email }})</span>
                        </div>
                    </div>
                @else
                    <div class="p-3 rounded-xl bg-amber-50 text-amber-800 text-xs font-medium">
                        Aucun syndic n'est encore assigné à votre résidence.
                    </div>
                @endif
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-xs">URG</div>
                    <div>
                        <span class="font-bold text-slate-900 block">Urgence / Gardiennage</span>
                        <span class="text-xs text-slate-500 block">Poste de garde (+212 5 22 99 88 77)</span>
                    </div>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Tables & Activity Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- My Payments History (2 Cols) -->
        <div class="lg:col-span-2">
            <x-card title="Historique de Mes Paiements" subtitle="Vos reçus de cotisations enregistrés" :empty="$myPayments->isEmpty()">
                <x-table :headers="['Mois Concerné', 'Date de Paiement', 'Montant', 'Mode', 'Statut', 'Reçu']">
                    @foreach ($myPayments as $payment)
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $payment->month }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ optional($payment->payment_date)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 font-bold text-slate-900">{{ number_format($payment->amount, 2, ',', ' ') }} DH</td>
                            <td class="px-6 py-4 text-slate-600">{{ ucfirst($payment->payment_method) }}</td>
                            <td class="px-6 py-4">
                                @if ($payment->status === 'paid')
                                    <x-badge variant="success" dot>Confirmé</x-badge>
                                @else
                                    <x-badge variant="warning" dot>En traitement</x-badge>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('syndic.payments.receipt', $payment->id) }}" class="text-emerald-600 font-semibold text-xs hover:underline flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </x-card>
        </div>

        <!-- My Complaints & Announcements Sidebar -->
        <div class="space-y-6">
            <x-card title="Mes Réclamations Récentes">
                <div class="space-y-3">
                    @forelse ($myComplaints as $complaint)
                        <a href="{{ route('syndic.complaints.show', $complaint->id) }}" class="block p-3.5 rounded-xl border border-slate-100 bg-emerald-50/20 hover:border-emerald-300 transition">
                            <div class="flex items-center justify-between mb-1">
                                <x-badge variant="warning" size="sm">{{ ucfirst(str_replace('_', ' ', $complaint->status)) }}</x-badge>
                                <span class="text-[10px] text-slate-400">{{ $complaint->created_at->diffForHumans() }}</span>
                            </div>
                            <h4 class="text-xs font-bold text-slate-900">{{ $complaint->title }}</h4>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $complaint->description }}</p>
                        </a>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">Aucune réclamation en cours.</p>
                    @endforelse
                </div>
            </x-card>

            <x-card title="Dernières Annonces">
                <div class="space-y-3 text-xs text-slate-600">
                    @foreach ($announcements as $ann)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="font-bold text-slate-900 block mb-0.5">{{ $ann->title }}</span>
                            <p class="text-slate-500">{{ $ann->content }}</p>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>
    </div>
</x-resident-layout>
