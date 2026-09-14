<x-resident-layout>
    <x-slot name="header">Mes Paiements & Reçus</x-slot>

    <div class="space-y-6">
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
                            @else
                                <x-badge variant="warning" dot>En attente</x-badge>
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
