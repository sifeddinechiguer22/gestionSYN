<x-syndic-layout>
    <x-slot name="header">Gestion des Résidents & Copropriétaires</x-slot>

    @if (session('success'))
        <x-alert type="success" title="Succès !" dismissible>{{ session('success') }}</x-alert>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Répertoire des Copropriétaires</h2>
            <p class="text-xs text-slate-500 mt-0.5">Annuaire officiel des résidents avec coordonnées et logements attribués</p>
        </div>
        <button x-data @click="$dispatch('open-modal', 'create-resident')">
            <x-button variant="primary" size="md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Ajouter un Résident
            </x-button>
        </button>
    </div>

    <!-- Search Bar -->
    <x-card padding>
        <form method="GET" action="{{ route('syndic.residents') }}">
            <x-input
                name="search"
                placeholder="Rechercher par nom, email, téléphone..."
                value="{{ request('search') }}"
                icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>'
            />
        </form>
    </x-card>

    <x-card padding={false}>
        <x-table :headers="['Nom & Prénom', 'Email', 'Téléphone', 'Appartement Associé', 'Inscrit Le', 'Statut']" :empty="$residents->isEmpty()">
            @foreach ($residents as $res)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-brand-100 text-brand-700 font-bold flex items-center justify-center text-xs">
                                {{ strtoupper(substr($res->name, 0, 2)) }}
                            </div>
                            <span class="font-bold text-slate-900">{{ $res->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-600">{{ $res->email }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $res->phone ?? 'N/A' }}</td>
                    <td class="px-6 py-4 font-semibold text-brand-600">
                        @if ($res->apartments->isNotEmpty())
                            @foreach ($res->apartments as $a)
                                Appt {{ $a->number }} ({{ optional($a->building)->name }})
                            @endforeach
                        @else
                            <span class="text-slate-400 font-normal">Non attribué</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-500 text-xs">{{ $res->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4"><x-badge variant="success" dot>Actif</x-badge></td>
                </tr>
            @endforeach
        </x-table>
        <div class="p-4 border-t border-slate-100">
            {{ $residents->links() }}
        </div>
    </x-card>

    <!-- Modal Create Resident -->
    <x-modal name="create-resident" title="Ajouter un Copropriétaire">
        <form action="{{ route('syndic.residents.store') }}" method="POST" class="space-y-4">
            @csrf
            <x-form-group label="Nom et Prénom" name="name" required>
                <x-input name="name" placeholder="Ex: Hassan Skalli" required />
            </x-form-group>

            <x-form-group label="Adresse Email" name="email" required>
                <x-input name="email" type="email" placeholder="hassan@residence.ma" required />
            </x-form-group>

            <x-form-group label="Téléphone" name="phone">
                <x-input name="phone" placeholder="+212 6 00 00 00 00" />
            </x-form-group>

            <x-form-group label="Mot de passe provisoire" name="password" required>
                <x-input name="password" type="password" value="password" required />
            </x-form-group>

            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <x-button variant="ghost" type="button" x-data @click="$dispatch('close-modal', 'create-resident')">Annuler</x-button>
                <x-button variant="primary" type="submit">Inscrire le Résident</x-button>
            </div>
        </form>
    </x-modal>
</x-syndic-layout>
