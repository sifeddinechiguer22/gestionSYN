<x-syndic-layout>
    <x-slot name="header">Enregistrer un Nouveau Paiement</x-slot>

    <!-- Page Header & Back Button -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Saisie de Cotisation de Syndic</h2>
            <p class="text-xs text-slate-500 mt-0.5">Veuillez renseigner les détails du règlement effectué par le copropriétaire</p>
        </div>
        <a href="{{ route('syndic.payments.index') }}">
            <x-button variant="outline" size="sm">
                &larr; Retour à la liste
            </x-button>
        </a>
    </div>

    <!-- Main Form Container -->
    <div class="max-w-3xl mx-auto">
        <x-card title="Formulaire de Règlement" subtitle="Les champs marqués d'une astérisque (*) sont obligatoires">
            <form action="{{ route('syndic.payments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Select Resident / Apartment -->
                <x-form-group label="Copropriétaire / Appartement" name="apartment_id" required help="Sélectionnez l'appartement concerné par la cotisation">
                    <select id="apartment_id" name="apartment_id" class="w-full rounded-xl text-sm border-slate-200 focus:border-brand-500 focus:ring-brand-500/20 py-2.5 px-4 bg-white shadow-xs">
                        <option value="">-- Choisir un appartement / Résident --</option>
                        @foreach ($apartments as $appt)
                            <option value="{{ $appt->id }}" {{ old('apartment_id') == $appt->id ? 'selected' : '' }}>
                                Appt N° {{ $appt->number }} — {{ optional($appt->resident)->name ?? 'Vacant' }} ({{ optional($appt->building)->name }}, Étage {{ $appt->floor }})
                            </option>
                        @endforeach
                    </select>
                </x-form-group>

                <!-- Amount & Payment Date Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <x-form-group label="Montant du règlement (DH)" name="amount" required help="Montant standard de la cotisation mensuelle : 800 DH">
                        <x-input
                            name="amount"
                            type="number"
                            placeholder="800"
                            value="{{ old('amount', '800') }}"
                            icon='<span class="font-bold text-xs">DH</span>'
                        />
                    </x-form-group>

                    <x-form-group label="Date de Paiement" name="payment_date" required>
                        <x-input
                            name="payment_date"
                            type="date"
                            value="{{ old('payment_date', date('Y-m-d')) }}"
                        />
                    </x-form-group>
                </div>

                <!-- Month & Payment Method Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <x-form-group label="Mois Concerné" name="month" required>
                        <select id="month" name="month" class="w-full rounded-xl text-sm border-slate-200 focus:border-brand-500 focus:ring-brand-500/20 py-2.5 px-4 bg-white shadow-xs">
                            <option value="2026-09" selected>Septembre 2026</option>
                            <option value="2026-10">Octobre 2026</option>
                            <option value="2026-08">Août 2026</option>
                            <option value="2026-07">Juillet 2026</option>
                        </select>
                    </x-form-group>

                    <x-form-group label="Mode de Règlement" name="payment_method" required>
                        <select id="payment_method" name="payment_method" class="w-full rounded-xl text-sm border-slate-200 focus:border-brand-500 focus:ring-brand-500/20 py-2.5 px-4 bg-white shadow-xs">
                            <option value="virement" {{ old('payment_method') === 'virement' ? 'selected' : '' }}>Virement Bancaire</option>
                            <option value="especes" {{ old('payment_method') === 'especes' ? 'selected' : '' }}>Espèces (Reçu physique)</option>
                            <option value="cheque" {{ old('payment_method') === 'cheque' ? 'selected' : '' }}>Chèque</option>
                            <option value="carte" {{ old('payment_method') === 'carte' ? 'selected' : '' }}>Carte Bancaire / En ligne</option>
                        </select>
                    </x-form-group>
                </div>

                <!-- Status Select -->
                <x-form-group label="Statut du paiement" name="status" required>
                    <select id="status" name="status" class="w-full rounded-xl text-sm border-slate-200 focus:border-brand-500 focus:ring-brand-500/20 py-2.5 px-4 bg-white shadow-xs">
                        <option value="paid" selected>Payé (Confirmé)</option>
                        <option value="pending">En attente de validation</option>
                        <option value="late">En retard / Impayé</option>
                    </select>
                </x-form-group>

                <!-- Reference / File Upload -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <x-form-group label="Référence / N° de Chèque / Virement" name="reference" help="Ex: N° de transaction ou numéro du chèque">
                        <x-input
                            name="reference"
                            placeholder="Ex: VIR-2026-90412"
                            value="{{ old('reference') }}"
                        />
                    </x-form-group>

                    <x-form-group label="Justificatif / Reçu (PDF/JPG)" name="proof_file" help="Fichier joint optionnel (Max: 5Mo)">
                        <input type="file" name="proof_file" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 cursor-pointer border border-slate-200 rounded-xl" />
                    </x-form-group>
                </div>

                <!-- Notes / Remarks -->
                <x-form-group label="Remarques ou Observations" name="notes">
                    <textarea name="notes" rows="3" class="w-full rounded-xl text-sm border-slate-200 focus:border-brand-500 focus:ring-brand-500/20 p-3 bg-white shadow-xs" placeholder="Remarques éventuelles sur ce paiement...">{{ old('notes') }}</textarea>
                </x-form-group>

                <!-- Form Submit Action Buttons -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('syndic.payments.index') }}">
                        <x-button variant="ghost" type="button">Annuler</x-button>
                    </a>
                    <x-button variant="primary" type="submit" size="lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Enregistrer et Générer Reçu PDF
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-syndic-layout>
