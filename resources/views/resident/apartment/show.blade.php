<x-resident-layout>
    <x-slot name="header">Mon Logement</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <x-card title="Fiche Signalétique de Mon Appartement" subtitle="Informations sur votre logement au sein de la copropriété">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Nom de la Résidence :</span>
                        <span class="font-bold text-slate-900">{{ optional(optional(optional($apartment)->building)->residence)->name ?? 'Non renseignée' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Bâtiment / Immeuble :</span>
                        <span class="font-semibold text-slate-900">{{ optional(optional($apartment)->building)->name ?? 'Non renseigné' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Numéro Appartement :</span>
                        <span class="font-bold text-slate-900">Appt N° {{ optional($apartment)->number ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Étage :</span>
                        <span class="font-semibold text-slate-900">{{ optional($apartment)->floor ?? 0 }}ème Étage</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Cotisation Mensuelle :</span>
                        <span class="font-extrabold text-emerald-600">{{ number_format(optional($apartment)->monthly_fee ?? 800, 2, ',', ' ') }} DH / mois</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Statut d'Occupation :</span>
                        <x-badge variant="success" size="sm" dot>Occupé</x-badge>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
</x-resident-layout>
