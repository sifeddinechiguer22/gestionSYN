<x-resident-layout>
    <x-slot name="header">Mes Notifications</x-slot>

    <div class="max-w-4xl mx-auto space-y-4">
        <x-card title="Mes Notifications & Alertes" subtitle="Historique des mises à jour sur votre logement">
            <div class="divide-y divide-slate-100">
                <div class="py-3.5 flex items-start gap-4">
                    <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xs shrink-0">✓</div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-900">Cotisation validée pour Septembre 2026</p>
                        <p class="text-xs text-slate-500 mt-0.5">Votre paiement de 800 DH par Virement bancaire a été validé. Reçu PDF disponible.</p>
                        <span class="text-[10px] text-slate-400 mt-1 block">Il y a 2 jours</span>
                    </div>
                </div>

                <div class="py-3.5 flex items-start gap-4">
                    <div class="w-9 h-9 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-bold text-xs shrink-0">💬</div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-900">Le Syndic a répondu à votre réclamation #TK-2026-042</p>
                        <p class="text-xs text-slate-500 mt-0.5">« La société Otis a été dépêchée sur place. »</p>
                        <span class="text-[10px] text-slate-400 mt-1 block">Hier</span>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
</x-resident-layout>
