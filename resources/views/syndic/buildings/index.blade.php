<x-syndic-layout>
    <x-slot name="header">Gestion des Bâtiments</x-slot>

    @if (session('success'))
        <x-alert type="success" title="Succès !" dismissible>{{ session('success') }}</x-alert>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Bâtiments & Blocs d'Immeubles</h2>
            <p class="text-xs text-slate-500 mt-0.5">Structure physique des blocs composants la copropriété</p>
        </div>
        <button x-data @click="$dispatch('open-modal', 'create-building')" class="inline-flex">
            <x-button variant="primary" size="md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Nouveau Bâtiment
            </x-button>
        </button>
    </div>

    <x-card padding={false}>
        <x-table :headers="['Nom du Bâtiment', 'Code Identifiant', 'Nombre d\'Étages', 'Nombre d\'Appartements', 'Actions']" :empty="$buildings->isEmpty()">
            @foreach ($buildings as $building)
                <tr>
                    <td class="px-6 py-4 font-bold text-slate-900 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-brand-50 text-brand-600 font-bold flex items-center justify-center text-xs">
                            {{ substr($building->name, -1) }}
                        </div>
                        <span>{{ $building->name }}</span>
                    </td>
                    <td class="px-6 py-4"><x-badge variant="neutral" size="sm">{{ $building->code }}</x-badge></td>
                    <td class="px-6 py-4 font-semibold text-slate-700">{{ $building->floors_count }} étages</td>
                    <td class="px-6 py-4 font-extrabold text-brand-600">{{ $building->apartments_count }} appartements</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('syndic.apartments') }}?building={{ $building->id }}" class="text-xs font-semibold text-brand-600 hover:underline">
                            Voir les appartements &rarr;
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </x-card>

    <!-- Modal Form for Create Building -->
    <x-modal name="create-building" title="Ajouter un Nouveau Bâtiment">
        <form action="{{ route('syndic.buildings.store') }}" method="POST" class="space-y-4">
            @csrf
            <x-form-group label="Nom du Bâtiment" name="name" required>
                <x-input name="name" placeholder="Ex: Bâtiment D" required />
            </x-form-group>

            <x-form-group label="Code Identifiant" name="code" required>
                <x-input name="code" placeholder="Ex: BAT-D" required />
            </x-form-group>

            <x-form-group label="Nombre d'Étages" name="floors_count" required>
                <x-input name="floors_count" type="number" placeholder="5" value="5" required />
            </x-form-group>

            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <x-button variant="ghost" type="button" x-data @click="$dispatch('close-modal', 'create-building')">Annuler</x-button>
                <x-button variant="primary" type="submit">Enregistrer Bâtiment</x-button>
            </div>
        </form>
    </x-modal>
</x-syndic-layout>
