<x-resident-layout>
    <x-slot name="header">Annonces & Fil d'Actualités</x-slot>

    <div class="space-y-4">
        @forelse ($announcements as $ann)
            <div class="p-6 bg-white rounded-2xl border border-slate-100 shadow-card flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-2 flex-1">
                    <div class="flex items-center gap-2">
                        @if ($ann->pinned)
                            <x-badge variant="danger" size="sm">📌 Épinglée</x-badge>
                        @endif
                        <x-badge :variant="$ann->type === 'urgent' ? 'danger' : 'info'" size="sm">
                            {{ ucfirst($ann->type) }}
                        </x-badge>
                        <span class="text-xs text-slate-400">Publié le {{ optional($ann->published_at)->format('d/m/Y à H:i') }}</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">{{ $ann->title }}</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">{{ $ann->content }}</p>
                </div>
            </div>
        @empty
            <x-card>
                <p class="text-xs text-slate-400 text-center py-6">Aucune annonce actuellement.</p>
            </x-card>
        @endforelse
    </div>
</x-resident-layout>
