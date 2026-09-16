<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Syndic Manager' }} - Administration Résidence</title>

    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-full text-slate-800" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen bg-slate-50 flex">
        <!-- Sidebar Mobile Overlay -->
        <div 
            x-show="sidebarOpen" 
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false" 
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-40 lg:hidden"
            style="display: none;"
        ></div>

        <!-- Sidebar Navigation -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-white flex flex-col transition-transform duration-300 ease-in-out lg:static lg:z-auto border-r border-slate-800 shrink-0"
        >
            <!-- Logo & Title -->
            <div class="h-20 px-6 flex items-center justify-between border-b border-slate-800/80">
                <a href="{{ route('syndic.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 to-cyan-500 flex items-center justify-center text-white shadow-lg shadow-brand-500/25">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-bold text-lg tracking-tight text-white block leading-tight">SyndicManager</span>
                        <span class="text-[10px] uppercase tracking-widest font-semibold text-brand-400">Espace Syndic</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Residence Switcher Badge -->
            @php
                $sidebarResidence = Auth::user()?->managedResidence;
                $sidebarApartmentCount = $sidebarResidence
                    ? $sidebarResidence->buildings()->withCount('apartments')->get()->sum('apartments_count')
                    : 0;
                $sidebarComplaintCount = $sidebarResidence
                    ? \App\Models\Complaint::whereHas('apartment.building', fn ($query) => $query->where('residence_id', $sidebarResidence->id))
                        ->whereIn('status', ['déposée', 'en_attente', 'open', 'in_progress'])
                        ->count()
                    : 0;
                $sidebarNotificationCount = Auth::user()?->unreadNotifications()->count() ?? 0;
            @endphp
            <div class="px-6 py-4 bg-slate-950/40 border-b border-slate-800/60">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5 overflow-hidden">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 shrink-0 animate-pulse"></span>
                        <div class="truncate">
                            <span class="text-xs font-semibold text-slate-200 block truncate">{{ $sidebarResidence?->name ?? 'Aucune résidence enregistrée' }}</span>
                            <span class="text-[10px] text-slate-400 truncate">{{ $sidebarResidence?->city ?? 'Ville non renseignée' }} — {{ $sidebarApartmentCount }} Appts</span>
                        </div>
                    </div>
                    <x-badge variant="neutral" size="sm">Syndic</x-badge>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 overflow-y-auto space-y-1.5 custom-scrollbar">
                @php
                    $navItems = [
                        ['route' => 'syndic.dashboard', 'label' => 'Tableau de bord', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                        ['route' => 'syndic.residence', 'label' => 'Ma Résidence', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>'],
                        ['route' => 'syndic.buildings', 'label' => 'Bâtiments', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>'],
                        ['route' => 'syndic.apartments', 'label' => 'Appartements', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>'],
                        ['route' => 'syndic.residents', 'label' => 'Résidents', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>'],
                        ['route' => 'syndic.payments.index', 'label' => 'Paiements & Cotisations', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                        ['route' => 'syndic.expenses', 'label' => 'Dépenses & Charges', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>'],
                        ['route' => 'syndic.complaints', 'label' => 'Réclamations', 'badge' => $sidebarComplaintCount, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>'],
                        ['route' => 'syndic.documents', 'label' => 'Documents', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                        ['route' => 'syndic.announcements', 'label' => 'Annonces', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>'],
                        ['route' => 'syndic.notifications', 'label' => 'Notifications', 'badge' => $sidebarNotificationCount, 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>', 'badgeId' => 'syndic-notification-count'],
                    ];
                @endphp

                @foreach ($navItems as $item)
                    @php
                        $isActive = request()->routeIs($item['route']) || (isset($item['pattern']) && request()->is($item['pattern']));
                    @endphp
                    <a 
                        href="{{ route($item['route']) }}" 
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group {{ $isActive ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
                    >
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 transition-colors {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $item['icon'] !!}
                            </svg>
                            <span>{{ $item['label'] }}</span>
                        </div>
                        @if (isset($item['badge']))
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $isActive ? 'bg-white/20 text-white' : 'bg-rose-500/20 text-rose-300 border border-rose-500/30' }}">
                                <span id="{{ $item['badgeId'] ?? '' }}">{{ $item['badge'] }}</span>
                            </span>
                        @endif
                    </a>
                @endforeach
            </nav>

            <!-- User Footer Profile -->
            <div class="p-4 border-t border-slate-800 bg-slate-950/40">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="w-9 h-9 rounded-full bg-brand-500/20 border border-brand-500/30 text-brand-300 font-semibold flex items-center justify-center text-sm shrink-0">
                            {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 2)) }}
                        </div>
                        <div class="truncate">
                            <span class="text-xs font-semibold text-white block truncate">{{ Auth::user()->name ?? 'Syndic' }}</span>
                            <span class="text-[10px] text-slate-400 block truncate">{{ Auth::user()->email ?? '' }}</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Déconnexion" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-slate-800 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Navbar Header -->
            <header class="h-20 bg-white border-b border-slate-100 px-6 flex items-center justify-between sticky top-0 z-30 shadow-xs">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden text-slate-600 hover:text-slate-900 p-2 rounded-xl border border-slate-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900 tracking-tight">{{ $header ?? 'Tableau de bord' }}</h1>
                        <p class="text-xs text-slate-500 hidden sm:block">Gestion immobilière & Syndic de Copropriété</p>
                    </div>
                </div>

                <!-- Right Action Buttons & Profile Dropdown -->
                <div class="flex items-center gap-4">
                    <!-- Notification Dropdown Demo -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-xl relative transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 rounded-full bg-rose-500 ring-2 ring-white animate-pulse"></span>
                        </button>

                        <div 
                            x-show="open" 
                            @click.outside="open = false" 
                            x-transition
                            class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 divide-y divide-slate-100"
                            style="display: none;"
                        >
                            <div class="px-4 py-2.5 flex items-center justify-between">
                                <span class="font-bold text-sm text-slate-900">Notifications (<span id="syndic-header-notification-count">{{ $sidebarNotificationCount }}</span>)</span>
                                <form method="POST" action="{{ route('syndic.notifications.read-all') }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-brand-600 font-semibold hover:underline">Tout marquer lu</button>
                                </form>
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                @forelse (Auth::user()->notifications()->latest()->take(5)->get() as $notification)
                                    <a href="{{ route('syndic.notifications') }}" class="block px-4 py-3 hover:bg-slate-50 transition">
                                        <p class="text-xs text-slate-800 font-medium">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $notification->data['message'] ?? '' }}</p>
                                        <span class="text-[10px] text-slate-400 mt-0.5 block">{{ $notification->created_at->diffForHumans() }}</span>
                                    </a>
                                @empty
                                    <p class="px-4 py-5 text-xs text-slate-400">Aucune notification.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Profile Avatar -->
                    <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 text-white font-bold flex items-center justify-center shadow-xs">
                            {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 2)) }}
                        </div>
                        <div class="hidden lg:block text-left">
                            <span class="text-sm font-bold text-slate-900 block leading-tight">{{ Auth::user()->name ?? 'Syndic' }}</span>
                            <span class="text-xs text-slate-500 block">Syndic Principal</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Scrollable Page Body -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8 space-y-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
<script>
    (() => {
        const countUrl = @json(route('syndic.notifications.count'));
        const updateCount = () => fetch(countUrl, { headers: { 'Accept': 'application/json' } })
            .then(response => response.json())
            .then(({ count }) => {
                document.querySelectorAll('#syndic-notification-count, #syndic-header-notification-count').forEach((element) => {
                    element.textContent = count;
                });
            })
            .catch(() => {});
        setInterval(updateCount, 5000);
    })();
</script>
