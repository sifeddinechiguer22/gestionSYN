<x-syndic-layout>
    <x-slot name="header">Gestion des Appartements</x-slot>

    @if (session('success'))
        <x-alert type="success" title="Succès !" dismissible>{{ session('success') }}</x-alert>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Liste des Logements & Lots</h2>
            <p class="text-xs text-slate-500 mt-0.5">Inventaire des appartements, résidents associés et montants des cotisations</p>
        </div>
        <button x-data @click="$dispatch('open-modal', 'create-apartment')">
            <x-button variant="primary" size="md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Nouvel Appartement
            </x-button>
        </button>
    </div>

    <!-- Filters Bar -->
    <x-card padding>
        <form method="GET" action="{{ route('syndic.apartments') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <select name="building" onchange="this.form.submit()" class="w-full rounded-xl text-sm border-slate-200 py-2.5 px-3 bg-white">
                <option value="">Tous les Bâtiments</option>
                @foreach ($buildings as $b)
                    <option value="{{ $b->id }}" {{ request('building') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                @endforeach
            </select>

            <select name="status" onchange="this.form.submit()" class="w-full rounded-xl text-sm border-slate-200 py-2.5 px-3 bg-white">
                <option value="">Tous les statuts</option>
                <option value="occupied" {{ request('status') === 'occupied' ? 'selected' : '' }}>Occupé</option>
                <option value="vacant" {{ request('status') === 'vacant' ? 'selected' : '' }}>Vacant</option>
            </select>
        </form>
    </x-card>

    <x-card padding={false}>
        <x-table :headers="['Numéro Appt', 'Bâtiment', 'Étage', 'Occupant / Résident', 'Cotisation Mensuelle', 'Statut']" :empty="$apartments->isEmpty()">
            @foreach ($apartments as $appt)
                <tr>
                    <td class="px-6 py-4 font-bold text-slate-900">Appt N° {{ $appt->number }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-700">{{ optional($appt->building)->name }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $appt->floor }}ème étage</td>
                    <td class="px-6 py-4 font-semibold text-slate-900">
                        {{ optional($appt->resident)->name ?? 'Logement Vacant' }}
                    </td>
                    <td class="px-6 py-4 font-extrabold text-emerald-600">{{ number_format($appt->monthly_fee, 2, ',', ' ') }} DH</td>
                    <td class="px-6 py-4">
                        @if ($appt->status === 'occupied')
                            <x-badge variant="success" dot>Occupé</x-badge>
                        @else
                            <x-badge variant="warning" dot>Vacant</x-badge>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-table>
        <div class="p-4 border-t border-slate-100">
            {{ $apartments->links() }}
        </div>
    </x-card>

    <!-- Modal Create Apartment -->
    <x-modal name="create-apartment" title="Créer un Appartement">
        <form action="{{ route('syndic.apartments.store') }}" method="POST" class="space-y-4">
            @csrf
            <x-form-group label="Bâtiment" name="building_id" required>
                <select name="building_id" class="w-full rounded-xl text-sm border-slate-200 py-2.5 px-3 bg-white" required>
                    @foreach ($buildings as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </x-form-group>

            <div class="grid grid-cols-2 gap-4">
                <x-form-group label="Numéro d'Appartement" name="number" required>
                    <x-input name="number" placeholder="Ex: 15" required />
                </x-form-group>
                <x-form-group label="Étage" name="floor" required>
                    <x-input name="floor" type="number" placeholder="3" value="3" required />
                </x-form-group>
            </div>

            <x-form-group label="Cotisation Mensuelle (DH)" name="monthly_fee" required>
                <x-input name="monthly_fee" type="number" placeholder="800" value="800" required />
            </x-form-group>

            <x-form-group label="Résident Affecté" name="user_id">
                <select name="user_id" class="w-full rounded-xl text-sm border-slate-200 py-2.5 px-3 bg-white">
                    <option value="">-- Aucun (Vacant) --</option>
                    @foreach ($residents as $r)
                        <option value="{{ $r->id }}">{{ $r->name }} ({{ $r->email }})</option>
                    @endforeach
                </select>
            </x-form-group>

            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <x-button variant="ghost" type="button" x-data @click="$dispatch('close-modal', 'create-apartment')">Annuler</x-button>
                <x-button variant="primary" type="submit">Enregistrer Appartement</x-button>
            </div>
        </form>
    </x-modal>
</x-syndic-layout>
