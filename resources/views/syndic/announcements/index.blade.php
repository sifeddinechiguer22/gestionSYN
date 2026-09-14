<x-syndic-layout>
    <x-slot name="header">Annonces & Communication Copropriétaires</x-slot>

    @if (session('success'))
        <x-alert type="success" title="Succès !" dismissible>{{ session('success') }}</x-alert>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Annonces Publiées</h2>
            <p class="text-xs text-slate-500 mt-0.5">Diffusion des informations importantes, convocations et travaux</p>
        </div>
        <button x-data @click="$dispatch('open-modal', 'create-announcement')">
            <x-button variant="primary" size="md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Publier une Annonce
            </x-button>
        </button>
    </div>

    <div class="space-y-4">
        @forelse ($announcements as $ann)
            <div class="p-6 bg-white rounded-2xl border border-slate-100 shadow-card flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-2 flex-1">
                    <div class="flex items-center gap-2">
                        @if ($ann->pinned)
                            <x-badge variant="danger" size="sm">📌 Épinglée</x-badge>
                        @endif
                        <x-badge :variant="$ann->type === 'urgent' ? 'danger' : ($ann->type === 'maintenance' ? 'warning' : 'info')" size="sm">
                            {{ ucfirst($ann->type) }}
                        </x-badge>
                        <span class="text-xs text-slate-400">Publié le {{ optional($ann->published_at)->format('d/m/Y à H:i') }}</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">{{ $ann->title }}</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">{{ $ann->content }}</p>
                </div>
                <div class="text-xs text-slate-400 shrink-0">
                    Auteur : <strong>{{ optional($ann->author)->name ?? 'Syndic' }}</strong>
                </div>
            </div>
        @empty
            <x-card>
                <p class="text-xs text-slate-400 text-center py-6">Aucune annonce actuellement.</p>
            </x-card>
        @endforelse

        <div>
            {{ $announcements->links() }}
        </div>
    </div>

    <!-- Modal Create Announcement -->
    <x-modal name="create-announcement" title="Nouvelle Annonce">
        <form action="{{ route('syndic.announcements.store') }}" method="POST" class="space-y-4">
            @csrf
            <x-form-group label="Titre de l'Annonce" name="title" required>
                <x-input name="title" placeholder="Ex: Nettoyage annuel de la cuve d'eau" required />
            </x-form-group>

            <x-form-group label="Type d'Annonce" name="type" required>
                <select name="type" class="w-full rounded-xl text-sm border-slate-200 py-2.5 px-3 bg-white" required>
                    <option value="info">Information Générale</option>
                    <option value="urgent">Urgent</option>
                    <option value="event">Événement / Assemblée</option>
                    <option value="maintenance">Travaux / Maintenance</option>
                </select>
            </x-form-group>

            <x-form-group label="Contenu de l'Annonce" name="content" required>
                <textarea name="content" rows="4" class="w-full rounded-xl text-sm border-slate-200 p-3 bg-white shadow-xs" placeholder="Rédigez l'annonce..." required></textarea>
            </x-form-group>

            <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-slate-700">
                <input type="checkbox" name="pinned" value="1" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                <span>Épingler cette annonce en haut du fil d'actualités</span>
            </label>

            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <x-button variant="ghost" type="button" x-data @click="$dispatch('close-modal', 'create-announcement')">Annuler</x-button>
                <x-button variant="primary" type="submit">Diffuser l'Annonce</x-button>
            </div>
        </form>
    </x-modal>
</x-syndic-layout>
