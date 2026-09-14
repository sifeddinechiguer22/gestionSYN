<x-syndic-layout>
    <x-slot name="header">Centre de Notifications</x-slot>

    <div class="max-w-4xl mx-auto space-y-4">
        <x-card title="Notifications Système & Événements" subtitle="Historique des alertes reçues">
            <div class="divide-y divide-slate-100">
                <div class="py-3.5 flex items-start gap-4">
                    <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xs shrink-0">DH</div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-900">Ayoub Tazi a réglé sa cotisation de 800 DH</p>
                        <p class="text-xs text-slate-500 mt-0.5">Virement bancaire effectué pour le mois de Septembre 2026.</p>
                        <span class="text-[10px] text-slate-400 mt-1 block">Il y a 15 minutes</span>
                    </div>
                </div>

                <div class="py-3.5 flex items-start gap-4">
                    <div class="w-9 h-9 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-xs shrink-0">!</div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-900">Nouvelle réclamation urgente : Panne d'ascenseur Bât B</p>
                        <p class="text-xs text-slate-500 mt-0.5">Signalé par Ayoub Tazi (Appt 14).</p>
                        <span class="text-[10px] text-slate-400 mt-1 block">Il y a 2 heures</span>
                    </div>
                </div>

                <div class="py-3.5 flex items-start gap-4">
                    <div class="w-9 h-9 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold text-xs shrink-0">DOC</div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-900">Document publié : Règlement de Copropriété 2026</p>
                        <p class="text-xs text-slate-500 mt-0.5">Le document a été mis en ligne et rendu accessible aux résidents.</p>
                        <span class="text-[10px] text-slate-400 mt-1 block">Il y a 1 jour</span>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
</x-syndic-layout>
