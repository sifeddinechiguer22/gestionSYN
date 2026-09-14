<x-resident-layout>
    <x-slot name="header">Mes Réclamations & Signalements</x-slot>

    @if (session('success'))
        <x-alert type="success" title="Succès !" dismissible>{{ session('success') }}</x-alert>
    @endif

    <!-- Header action bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 01-2-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                Mes Réclamations
            </h2>
            <p class="text-xs text-slate-500 mt-1">Suivez l'évolution et le traitement de vos demandes par le Syndic de copropriété</p>
        </div>
        <x-button variant="success" size="md" x-data @click="$dispatch('open-modal', 'create-complaint')" class="shrink-0">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Signaler un problème
        </x-button>
    </div>

    <!-- Complaints list -->
    <div class="space-y-6">
        @forelse ($complaints as $complaint)
            <div class="p-6 bg-white rounded-2xl border border-slate-100 shadow-sm space-y-4">
                <!-- Header Info -->
                <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <x-badge :variant="$complaint->status_badge_variant" size="md">
                            {{ $complaint->status_label }}
                        </x-badge>
                        <x-badge variant="neutral" size="sm">#{{ $complaint->ticket_number }}</x-badge>
                        <span class="text-xs text-slate-400">Date de dépôt : {{ $complaint->created_at->format('d/m/Y à H:i') }}</span>
                    </div>

                    <!-- PDF Download Button -->
                    <a href="{{ route('resident.complaints.pdf', $complaint->id) }}" target="_blank">
                        <x-button variant="outline" size="sm" class="inline-flex items-center gap-1.5 text-xs">
                            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Télécharger PDF Récépissé
                        </x-button>
                    </a>
                </div>

                <!-- Complaint Description -->
                <div class="space-y-2">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Description du problème</h4>
                    <p class="text-sm text-slate-800 leading-relaxed bg-slate-50/70 p-3.5 rounded-xl border border-slate-100">
                        {{ $complaint->description }}
                    </p>
                </div>

                <!-- Status Stepper Bar: Déposée -> En attente -> Avec succès / Refusée -->
                <div class="pt-2">
                    <h4 class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Statut de la demande : Déposée &rarr; En attente &rarr; Résolution</h4>
                    <div class="grid grid-cols-3 gap-2 text-center text-xs font-semibold">
                        <!-- Step 1: Déposée -->
                        <div class="py-2 px-3 rounded-xl border {{ in_array($complaint->status, ['déposée', 'en_attente', 'avec_succès', 'refusée']) ? 'bg-sky-50 border-sky-300 text-sky-700 font-bold' : 'bg-slate-50 border-slate-200 text-slate-400' }}">
                            1. Déposée
                        </div>
                        <!-- Step 2: En attente -->
                        <div class="py-2 px-3 rounded-xl border {{ in_array($complaint->status, ['en_attente', 'avec_succès', 'refusée']) ? 'bg-amber-50 border-amber-300 text-amber-800 font-bold' : 'bg-slate-50 border-slate-200 text-slate-400' }}">
                            2. En attente
                        </div>
                        <!-- Step 3: avec_succès OR refusée -->
                        @if($complaint->status === 'refusée')
                            <div class="py-2 px-3 rounded-xl border bg-rose-50 border-rose-300 text-rose-700 font-bold">
                                3. Refusée
                            </div>
                        @elseif($complaint->status === 'avec_succès')
                            <div class="py-2 px-3 rounded-xl border bg-emerald-50 border-emerald-300 text-emerald-700 font-bold">
                                3. Avec succès
                            </div>
                        @else
                            <div class="py-2 px-3 rounded-xl border bg-slate-50 border-slate-200 text-slate-400">
                                3. Résolution
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Justification du refus (Seulement si refusée) -->
                @if ($complaint->status === 'refusée')
                    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 space-y-1">
                        <div class="flex items-center gap-2 text-rose-800 font-bold text-xs">
                            <svg class="w-4 h-4 shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>Justification du refus par le Syndic :</span>
                        </div>
                        <p class="text-xs text-rose-700 leading-relaxed font-medium pl-6">
                            {{ $complaint->rejection_reason ?? 'Aucune explication complémentaire n\'a été fournie.' }}
                        </p>
                    </div>
                @endif
            </div>
        @empty
            <x-card>
                <div class="text-center py-10">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-sm font-semibold text-slate-600">Aucune réclamation déposée</p>
                    <p class="text-xs text-slate-400 mt-1">Vous n'avez pas encore soumis de réclamation.</p>
                </div>
            </x-card>
        @endforelse

        <div>
            {{ $complaints->links() }}
        </div>
    </div>

    <!-- Modal Signaler un problème -->
    <x-modal name="create-complaint" title="Signaler un problème – Nouvelle Réclamation">
        <form action="{{ route('resident.complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="apartment_id" value="{{ optional($apartment)->id ?? 1 }}">

            <x-form-group label="Description du problème *" name="description" required>
                <textarea name="description" rows="6" class="w-full rounded-xl text-sm border-slate-200 p-3.5 bg-white shadow-xs focus:border-brand-500 focus:ring-brand-500/20" placeholder="Rédigez ici votre réclamation de manière détaillée (problème rencontré, localisation, impact)..." required></textarea>
            </x-form-group>

            <x-form-group label="Objet / Titre résumé (optionnel)" name="title">
                <x-input name="title" placeholder="Ex: Panne éclairage palier 3ème étage" />
            </x-form-group>

            <div class="grid grid-cols-2 gap-4">
                <x-form-group label="Catégorie" name="category">
                    <select name="category" class="w-full rounded-xl text-sm border-slate-200 py-2.5 px-3 bg-white">
                        <option value="plumbing">Plomberie / Eau</option>
                        <option value="elevator">Ascenseur</option>
                        <option value="electricity">Électricité / Éclairage</option>
                        <option value="noise">Nuisance Sonore</option>
                        <option value="cleanliness">Propreté / Nettoyage</option>
                        <option value="other" selected>Autre</option>
                    </select>
                </x-form-group>

                <x-form-group label="Priorité" name="priority">
                    <select name="priority" class="w-full rounded-xl text-sm border-slate-200 py-2.5 px-3 bg-white">
                        <option value="low">Basse</option>
                        <option value="medium" selected>Moyenne</option>
                        <option value="high">Haute</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </x-form-group>
            </div>

            <x-form-group label="Photo / Pièce jointe (optionnel)" name="attachment">
                <input type="file" name="attachment" class="w-full text-xs text-slate-500 border border-slate-200 rounded-xl" />
            </x-form-group>

            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <x-button variant="ghost" type="button" x-data @click="$dispatch('close-modal', 'create-complaint')">Annuler</x-button>
                <x-button variant="success" type="submit">Déposer la réclamation</x-button>
            </div>
        </form>
    </x-modal>
</x-resident-layout>
