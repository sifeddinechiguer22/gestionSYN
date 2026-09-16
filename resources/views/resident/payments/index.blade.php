<x-resident-layout>
    <x-slot name="header">Mes Paiements & Reçus</x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <x-alert type="success" title="Reçu envoyé" dismissible>{{ session('success') }}</x-alert>
        @endif

        @if ($errors->any())
            <x-alert type="error" title="Vérifiez le formulaire" dismissible>
                {{ $errors->first() }}
            </x-alert>
        @endif

        <x-card title="Ajouter un reçu de paiement" subtitle="Déclarez un paiement effectué pour l’envoyer au syndic">
            <form method="POST" action="{{ route('resident.payments.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <x-form-group label="Montant (DH)" name="amount" required>
                    <x-input name="amount" type="number" min="1" step="0.01" value="{{ old('amount') }}" required placeholder="Ex: 800" />
                </x-form-group>

                <x-form-group label="Mois concerné" name="month" required>
                    <x-input name="month" value="{{ old('month', now()->format('Y-m')) }}" required placeholder="Ex: 2026-09" />
                </x-form-group>

                <x-form-group label="Mode de paiement" name="payment_method" required>
                    <select name="payment_method" class="w-full rounded-xl border-slate-200 text-sm" required>
                        <option value="virement">Virement</option>
                        <option value="especes">Espèces</option>
                        <option value="cheque">Chèque</option>
                        <option value="carte">Carte</option>
                    </select>
                </x-form-group>

                <x-form-group label="Date du paiement" name="payment_date" required>
                    <x-input name="payment_date" type="date" value="{{ old('payment_date', now()->format('Y-m-d')) }}" required />
                </x-form-group>

                <x-form-group label="Justificatif (facultatif)" name="proof_file">
                    <x-input name="proof_file" type="file" accept=".pdf,.jpg,.jpeg,.png" />
                </x-form-group>

                <div class="md:col-span-2 flex items-center justify-between gap-4 pt-3 border-t border-slate-100">
                    <label class="flex items-center gap-2 text-xs text-slate-600">
                        <input type="checkbox" name="confirmation" value="1" required class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        Oui, je confirme avoir effectué ce paiement.
                    </label>
                    <button type="submit" class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-600 text-white text-xs font-semibold hover:bg-emerald-700">
                        Ajouter le reçu
                    </button>
                </div>
            </form>
        </x-card>

        <x-card title="Historique Complet de Mes Cotisations" subtitle="Téléchargez vos reçus officiels au format PDF">
            <x-table :headers="['N° Reçu', 'Mois Concerné', 'Date de Règlement', 'Montant (DH)', 'Mode de Paiement', 'Statut', 'Reçu PDF']" :empty="$payments->isEmpty()">
                @foreach ($payments as $payment)
                    <tr>
                        <td class="px-6 py-4 font-mono font-bold text-slate-900">{{ $payment->receipt_number }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-700">{{ $payment->month }}</td>
                        <td class="px-6 py-4 text-slate-600 text-xs">{{ optional($payment->payment_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 font-extrabold text-slate-900">{{ number_format($payment->amount, 2, ',', ' ') }} DH</td>
                        <td class="px-6 py-4 text-slate-600 text-xs">{{ ucfirst($payment->payment_method) }}</td>
                        <td class="px-6 py-4">
                            @if ($payment->status === 'paid')
                                <x-badge variant="success" dot>Payé</x-badge>
                            @elseif ($payment->status === 'cancelled')
                                <x-badge variant="danger" dot>Annulé par le syndic</x-badge>
                            @elseif ($payment->status === 'late')
                                <x-badge variant="danger" dot>En retard</x-badge>
                            @else
                                <x-badge variant="warning" dot>En attente de validation</x-badge>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('syndic.payments.receipt', $payment->id) }}" class="text-xs font-bold text-emerald-600 hover:underline flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Télécharger PDF
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-table>
            <div class="p-4 border-t border-slate-100">
                {{ $payments->links() }}
            </div>
        </x-card>
    </div>
</x-resident-layout>
