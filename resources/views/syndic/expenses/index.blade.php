<x-syndic-layout>
    <x-slot name="header">Gestion des Dépenses & Charges</x-slot>

    @if (session('success'))
        <x-alert type="success" title="Succès !" dismissible>{{ session('success') }}</x-alert>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Suivi des Dépenses de la Copropriété</h2>
            <p class="text-xs text-slate-500 mt-0.5">Comptabilité des charges communes (Ascenseur, Électricité, Jardinage, Sécurité)</p>
        </div>
        <button x-data @click="$dispatch('open-modal', 'create-expense')">
            <x-button variant="primary" size="md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Ajouter une Dépense
            </x-button>
        </button>
    </div>

    <!-- Category Filter -->
    <x-card padding>
        <form method="GET" action="{{ route('syndic.expenses') }}" class="flex items-center gap-4">
            <select name="category" onchange="this.form.submit()" class="w-full sm:w-64 rounded-xl text-sm border-slate-200 py-2.5 px-3 bg-white">
                <option value="">Toutes les catégories</option>
                <option value="maintenance" {{ request('category') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                <option value="electricity" {{ request('category') === 'electricity' ? 'selected' : '' }}>Électricité</option>
                <option value="water" {{ request('category') === 'water' ? 'selected' : '' }}>Eau</option>
                <option value="cleaning" {{ request('category') === 'cleaning' ? 'selected' : '' }}>Nettoyage</option>
                <option value="security" {{ request('category') === 'security' ? 'selected' : '' }}>Sécurité</option>
                <option value="repairs" {{ request('category') === 'repairs' ? 'selected' : '' }}>Réparations</option>
            </select>
        </form>
    </x-card>

    <x-card padding={false}>
        <x-table :headers="['Intitulé Dépense', 'Catégorie', 'Fournisseur / Prestataire', 'Date Dépense', 'Montant (DH)']" :empty="$expenses->isEmpty()">
            @foreach ($expenses as $expense)
                <tr>
                    <td class="px-6 py-4 font-bold text-slate-900">{{ $expense->title }}</td>
                    <td class="px-6 py-4"><x-badge variant="info" size="sm">{{ ucfirst($expense->category) }}</x-badge></td>
                    <td class="px-6 py-4 text-slate-600">{{ $expense->vendor_name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-slate-600 text-xs">{{ optional($expense->expense_date)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 font-extrabold text-rose-600">{{ number_format($expense->amount, 2, ',', ' ') }} DH</td>
                </tr>
            @endforeach
        </x-table>
        <div class="p-4 border-t border-slate-100">
            {{ $expenses->links() }}
        </div>
    </x-card>

    <!-- Modal Create Expense -->
    <x-modal name="create-expense" title="Saisir une Dépense">
        <form action="{{ route('syndic.expenses.store') }}" method="POST" class="space-y-4">
            @csrf
            <x-form-group label="Libellé de la Dépense" name="title" required>
                <x-input name="title" placeholder="Ex: Réparation pompe de surpression" required />
            </x-form-group>

            <div class="grid grid-cols-2 gap-4">
                <x-form-group label="Catégorie" name="category" required>
                    <select name="category" class="w-full rounded-xl text-sm border-slate-200 py-2.5 px-3 bg-white" required>
                        <option value="maintenance">Maintenance</option>
                        <option value="electricity">Électricité</option>
                        <option value="water">Eau</option>
                        <option value="cleaning">Nettoyage</option>
                        <option value="security">Sécurité</option>
                        <option value="repairs">Réparations</option>
                    </select>
                </x-form-group>

                <x-form-group label="Montant (DH)" name="amount" required>
                    <x-input name="amount" type="number" placeholder="1500" required />
                </x-form-group>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <x-form-group label="Fournisseur / Societé" name="vendor_name">
                    <x-input name="vendor_name" placeholder="Ex: Lydec" />
                </x-form-group>

                <x-form-group label="Date de Dépense" name="expense_date" required>
                    <x-input name="expense_date" type="date" value="{{ date('Y-m-d') }}" required />
                </x-form-group>
            </div>

            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <x-button variant="ghost" type="button" x-data @click="$dispatch('close-modal', 'create-expense')">Annuler</x-button>
                <x-button variant="primary" type="submit">Enregistrer Dépense</x-button>
            </div>
        </form>
    </x-modal>
</x-syndic-layout>
