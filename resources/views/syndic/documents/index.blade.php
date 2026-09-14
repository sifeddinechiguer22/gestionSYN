<x-syndic-layout>
    <x-slot name="header">Gestion des Documents & Archives</x-slot>

    @if (session('success'))
        <x-alert type="success" title="Succès !" dismissible>{{ session('success') }}</x-alert>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Documents Officiels de la Résidence</h2>
            <p class="text-xs text-slate-500 mt-0.5">Règlement de copropriété, PV d'Assemblées Générales, Contrats et Factures</p>
        </div>
        <button x-data @click="$dispatch('open-modal', 'create-document')">
            <x-button variant="primary" size="md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Ajouter un Document
            </x-button>
        </button>
    </div>

    <x-card padding={false}>
        <x-table :headers="['Titre du Document', 'Catégorie', 'Taille Fichier', 'Date de Publication', 'Actions']" :empty="$documents->isEmpty()">
            @foreach ($documents as $doc)
                <tr>
                    <td class="px-6 py-4 font-bold text-slate-900 flex items-center gap-3">
                        <svg class="w-6 h-6 text-brand-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>{{ $doc->title }}</span>
                    </td>
                    <td class="px-6 py-4"><x-badge variant="neutral" size="sm">{{ strtoupper($doc->category) }}</x-badge></td>
                    <td class="px-6 py-4 text-slate-500 text-xs">{{ $doc->file_size ?? '1.5 MB' }}</td>
                    <td class="px-6 py-4 text-slate-600 text-xs">{{ $doc->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-xs font-semibold text-brand-600 hover:underline">
                            Télécharger (PDF) &rarr;
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-table>
        <div class="p-4 border-t border-slate-100">
            {{ $documents->links() }}
        </div>
    </x-card>

    <!-- Modal Create Document -->
    <x-modal name="create-document" title="Téléverser un Document">
        <form action="{{ route('syndic.documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <x-form-group label="Titre du Document" name="title" required>
                <x-input name="title" placeholder="Ex: Procès-Verbal AG 2026" required />
            </x-form-group>

            <x-form-group label="Catégorie" name="category" required>
                <select name="category" class="w-full rounded-xl text-sm border-slate-200 py-2.5 px-3 bg-white" required>
                    <option value="reglement">Règlement de Copropriété</option>
                    <option value="pv_ag">Procès-Verbal d'AG</option>
                    <option value="contrat">Contrat Prestataire</option>
                    <option value="facture">Facture / Justificatif</option>
                    <option value="bilan">Bilan Financier</option>
                    <option value="autre">Autre Document</option>
                </select>
            </x-form-group>

            <x-form-group label="Fichier (PDF, Docx, Max 10Mo)" name="document_file" required>
                <input type="file" name="document_file" class="w-full text-xs text-slate-500 border border-slate-200 rounded-xl" required />
            </x-form-group>

            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <x-button variant="ghost" type="button" x-data @click="$dispatch('close-modal', 'create-document')">Annuler</x-button>
                <x-button variant="primary" type="submit">Publier le Document</x-button>
            </div>
        </form>
    </x-modal>
</x-syndic-layout>
