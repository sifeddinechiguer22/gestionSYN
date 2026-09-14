<x-resident-layout>
    <x-slot name="header">Documents de la Résidence</x-slot>

    <div class="space-y-6">
        <x-card title="Bibliothèque de Documents Publics" subtitle="Consultez et téléchargez les règlements et bilans de copropriété">
            <x-table :headers="['Intitulé Document', 'Catégorie', 'Taille', 'Date', 'Téléchargement']" :empty="$documents->isEmpty()">
                @foreach ($documents as $doc)
                    <tr>
                        <td class="px-6 py-4 font-bold text-slate-900 flex items-center gap-3">
                            <svg class="w-6 h-6 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>{{ $doc->title }}</span>
                        </td>
                        <td class="px-6 py-4"><x-badge variant="neutral" size="sm">{{ strtoupper($doc->category) }}</x-badge></td>
                        <td class="px-6 py-4 text-slate-500 text-xs">{{ $doc->file_size ?? '1.5 MB' }}</td>
                        <td class="px-6 py-4 text-slate-600 text-xs">{{ $doc->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-xs font-bold text-emerald-600 hover:underline">
                                Télécharger (PDF) &rarr;
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </x-card>
    </div>
</x-resident-layout>
