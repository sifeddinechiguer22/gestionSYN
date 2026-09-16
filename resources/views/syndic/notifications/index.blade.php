<x-syndic-layout>
    <x-slot name="header">Centre de Notifications</x-slot>

    <div class="max-w-4xl mx-auto space-y-4">
        @if (session('success'))
            <x-alert type="success" title="Notifications" dismissible>{{ session('success') }}</x-alert>
        @endif
        <x-card title="Notifications Système & Événements" subtitle="Historique des alertes reçues">
            <div class="flex justify-end mb-3">
                <form method="POST" action="{{ route('syndic.notifications.read-all') }}">
                    @csrf
                    <button class="text-xs font-semibold text-brand-600 hover:underline">Tout marquer comme lu</button>
                </form>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($notifications as $notification)
                    <div class="py-3.5 flex items-start gap-4 {{ $notification->read_at ? '' : 'bg-brand-50/40' }}">
                        <div class="w-9 h-9 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold text-xs shrink-0">!</div>
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
</x-syndic-layout>
