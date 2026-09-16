<x-resident-layout>
    <x-slot name="header">Mes Notifications</x-slot>

    <div class="max-w-4xl mx-auto space-y-4">
        @if (session('success'))
            <x-alert type="success" title="Notifications" dismissible>{{ session('success') }}</x-alert>
        @endif
        <x-card title="Mes Notifications & Alertes" subtitle="Historique des mises à jour sur votre logement">
            <div class="divide-y divide-slate-100">
                @forelse ($notifications as $notification)
                    <div class="py-3.5 flex items-start gap-4 {{ $notification->read_at ? '' : 'bg-emerald-50/40' }}">
                        <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xs shrink-0">!</div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-slate-900">{{ $notification->data['title'] ?? 'Notification' }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $notification->data['message'] ?? '' }}</p>
                            <span class="text-[10px] text-slate-400 mt-1 block">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="py-8 text-center text-sm text-slate-400">Aucune notification pour le moment.</p>
                @endforelse
            </div>
            <div class="pt-4">{{ $notifications->links() }}</div>
        </x-card>
    </div>
</x-resident-layout>
