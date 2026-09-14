<x-syndic-layout>
    <x-slot name="header">Traitement de la Réclamation #{{ $complaint->ticket_number }}</x-slot>

    <!-- Success Flash Alert -->
    @if (session('success'))
        <x-alert type="success" title="Succès !" dismissible>
            {{ session('success') }}
        </x-alert>
    @endif

    <!-- Validation Errors Alert -->
    @if ($errors->any())
        <div class="p-4 mb-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700">
            <p class="font-bold mb-1">Attention, certaines données sont incomplètes :</p>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Page Header & Back Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('syndic.complaints') }}">
                <x-button variant="outline" size="sm">&larr; Retour aux réclamations</x-button>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">{{ $complaint->title ?: 'Réclamation #'.$complaint->ticket_number }}</h2>
                    <x-badge :variant="$complaint->status_badge_variant" size="md">{{ $complaint->status_label }}</x-badge>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">Déposée le {{ $complaint->created_at->format('d/m/Y à H:i') }} par <strong>{{ optional($complaint->resident)->name }} (Appt {{ optional($complaint->apartment)->number }})</strong></p>
            </div>
        </div>
        <div class="shrink-0">
            <a href="{{ route('syndic.complaints.pdf', $complaint->id) }}" target="_blank">
                <x-button variant="outline" size="sm" class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Télécharger PDF Réclamation
                </x-button>
            </a>
        </div>
    </div>

    <!-- Main Detail Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Ticket Information & Discussion Thread (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Ticket Description Card -->
            <x-card title="Description du Problème">
                <div class="text-slate-800 text-sm leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <p>{{ $complaint->description }}</p>
                </div>

                @if ($complaint->attachment)
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-2">Pièce Jointe</span>
                        <a href="{{ asset('storage/' . $complaint->attachment) }}" target="_blank" class="inline-flex items-center gap-3 p-2.5 rounded-xl border border-slate-200 bg-slate-50 text-xs text-slate-700 hover:border-brand-300">
                            <svg class="w-5 h-5 text-brand-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            <span class="font-medium">Voir le fichier joint</span>
                        </a>
                    </div>
                @endif

                @if ($complaint->status === 'refusée' && $complaint->rejection_reason)
                    <div class="mt-4 p-4 rounded-xl bg-rose-50 border border-rose-200 space-y-1">
                        <div class="font-bold text-xs text-rose-800 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            Justification du refus enregistrée :
                        </div>
                        <p class="text-xs text-rose-700 leading-relaxed font-medium pl-5">
                            {{ $complaint->rejection_reason }}
                        </p>
                    </div>
                @endif
            </x-card>

            <!-- Traitement et changement de statut par le Syndic -->
            <x-card title="Traitement de la réclamation par le Syndic">
                <form action="{{ route('syndic.complaints.reply', $complaint->id) }}" method="POST" x-data="{ status: '{{ old('status', $complaint->status) }}' }" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Choisir le statut de la réclamation *</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <!-- En attente -->
                            <label class="relative flex items-center p-3 rounded-xl border cursor-pointer transition"
                                   :class="status === 'en_attente' ? 'bg-amber-50 border-amber-400 ring-2 ring-amber-400/20' : 'bg-white border-slate-200 hover:border-slate-300'">
                                <input type="radio" name="status" value="en_attente" x-model="status" class="text-amber-600 focus:ring-amber-500">
                                <div class="ml-3">
                                    <span class="block text-xs font-bold text-slate-900">En attente</span>
                                    <span class="block text-[11px] text-slate-500">Reçue, non traitée</span>
                                </div>
                            </label>

                            <!-- Avec succès -->
                            <label class="relative flex items-center p-3 rounded-xl border cursor-pointer transition"
                                   :class="status === 'avec_succès' ? 'bg-emerald-50 border-emerald-400 ring-2 ring-emerald-400/20' : 'bg-white border-slate-200 hover:border-slate-300'">
                                <input type="radio" name="status" value="avec_succès" x-model="status" class="text-emerald-600 focus:ring-emerald-500">
                                <div class="ml-3">
                                    <span class="block text-xs font-bold text-slate-900">Avec succès</span>
                                    <span class="block text-[11px] text-slate-500">Problème résolu</span>
                                </div>
                            </label>

                            <!-- Refusée -->
                            <label class="relative flex items-center p-3 rounded-xl border cursor-pointer transition"
                                   :class="status === 'refusée' ? 'bg-rose-50 border-rose-400 ring-2 ring-rose-400/20' : 'bg-white border-slate-200 hover:border-slate-300'">
                                <input type="radio" name="status" value="refusée" x-model="status" class="text-rose-600 focus:ring-rose-500">
                                <div class="ml-3">
                                    <span class="block text-xs font-bold text-slate-900">Refusée</span>
                                    <span class="block text-[11px] text-slate-500">Demande rejetée</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Champ de Justification de refus (Obligatoire si statut = Refusée) -->
                    <div x-show="status === 'refusée'" x-transition class="p-4 rounded-2xl bg-rose-50 border border-rose-200 space-y-2">
                        <label for="rejection_reason" class="block text-xs font-bold text-rose-900 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            Justification du refus (Obligatoire) *
                        </label>
                        <p class="text-[11px] text-rose-700">Expliquez clairement à l'habitant le motif du refus de sa réclamation.</p>
                        <textarea name="rejection_reason" id="rejection_reason" rows="3"
                                  :required="status === 'refusée'"
                                  class="w-full rounded-xl text-xs border-rose-300 focus:border-rose-500 focus:ring-rose-500/20 p-3 bg-white shadow-xs"
                                  placeholder="Saisissez ici le motif du refus (ex: Intervention hors du domaine des parties communes...)"
                        >{{ old('rejection_reason', $complaint->rejection_reason) }}</textarea>
                        @error('rejection_reason')
                            <span class="text-xs text-rose-600 font-semibold block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Message optionnel dans le fil de discussion -->
                    <x-form-group label="Message explicatif pour l'habitant (optionnel)" name="reply_content">
                        <textarea name="reply_content" rows="2" class="w-full rounded-xl text-xs border-slate-200 focus:border-brand-500 focus:ring-brand-500/20 p-3 bg-white shadow-xs" placeholder="Ajouter une remarque dans l'historique d'échange..."></textarea>
                    </x-form-group>

                    <div class="flex justify-end pt-2">
                        <x-button variant="primary" size="md" type="submit">
                            Enregistrer le statut & répondre
                        </x-button>
                    </div>
                </form>
            </x-card>

            <!-- Reply Discussion Timeline -->
            <x-card title="Historique de l'échange" subtitle="{{ $complaint->replies->count() }} messages échangés">
                <div class="space-y-4">
                    @forelse ($complaint->replies as $reply)
                        @php
                            $isSyndicReply = optional($reply->user)->isSyndic();
                        @endphp
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full {{ $isSyndicReply ? 'bg-slate-900 text-white' : 'bg-brand-100 text-brand-700' }} font-bold flex items-center justify-center text-xs shrink-0">
                                {{ strtoupper(substr(optional($reply->user)->name ?? 'U', 0, 2)) }}
                            </div>
                            <div class="flex-1 {{ $isSyndicReply ? 'bg-brand-50/50 border-brand-100' : 'bg-slate-50 border-slate-100' }} rounded-2xl p-3.5 border">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-bold text-xs {{ $isSyndicReply ? 'text-brand-900' : 'text-slate-900' }}">
                                        {{ optional($reply->user)->name }} ({{ $isSyndicReply ? 'Syndic' : 'Résident' }})
                                    </span>
                                    <span class="text-[10px] text-slate-400">{{ $reply->created_at->format('d/m/Y à H:i') }}</span>
                                </div>
                                <p class="text-xs text-slate-800 leading-relaxed">{{ $reply->message }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">Aucun message dans l'historique.</p>
                    @endforelse
                </div>
            </x-card>
        </div>

        <!-- Right Side Sidebar Meta Card -->
        <div class="space-y-6">
            <x-card title="Métadonnées du Ticket">
                <div class="space-y-3 text-xs">
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Ticket N°</span>
                        <span class="font-mono font-bold text-slate-900">#{{ $complaint->ticket_number }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Statut actuel</span>
                        <x-badge :variant="$complaint->status_badge_variant" size="sm">{{ $complaint->status_label }}</x-badge>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Catégorie</span>
                        <span class="font-bold text-slate-900">{{ ucfirst($complaint->category) }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Bâtiment / Appt</span>
                        <span class="font-semibold text-slate-900">Appt {{ optional($complaint->apartment)->number }} ({{ optional(optional($complaint->apartment)->building)->name }})</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Signalé par</span>
                        <span class="font-semibold text-slate-900">{{ optional($complaint->resident)->name }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-slate-500">Créé le</span>
                        <span class="font-medium text-slate-700">{{ $complaint->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</x-syndic-layout>
