<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Espace Résident' }} - SyndicManager</title>

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

        <!-- Sidebar Navigation Resident -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-white flex flex-col transition-transform duration-300 ease-in-out lg:static lg:z-auto border-r border-slate-800 shrink-0"
        >
            <!-- Logo & Title -->
            <div class="h-20 px-6 flex items-center justify-between border-b border-slate-800/80">
                <a href="{{ route('resident.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white shadow-lg shadow-emerald-500/25">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-bold text-lg tracking-tight text-white block leading-tight">SyndicManager</span>
                        <span class="text-[10px] uppercase tracking-widest font-semibold text-emerald-400">Espace Résident</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Apartment Info Badge Header -->
            <div class="px-6 py-4 bg-slate-950/40 border-b border-slate-800/60">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-white block">Appartement N° 14</span>
                        <span class="text-[10px] text-slate-400 block">Bâtiment A — 3ème Étage</span>
                    </div>
                    <x-badge variant="success" size="sm" dot>À jour</x-badge>
                </div>
            </div>

            <!-- Navigation Links Resident -->
            @php $residentNotificationCount = Auth::user()?->unreadNotifications()->count() ?? 0; @endphp
            <nav class="flex-1 px-4 py-6 overflow-y-auto space-y-1.5 custom-scrollbar">
                @php
                    $residentItems = [
                        ['route' => 'resident.dashboard', 'label' => 'Tableau de bord', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                        ['route' => 'resident.apartment', 'label' => 'Mon Appartement', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>'],
                        ['route' => 'resident.payments', 'label' => 'Mes Paiements & Reçus', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>'],
                        ['route' => 'resident.complaints', 'label' => 'Mes Réclamations', 'badge' => '1', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>'],
                        ['route' => 'resident.documents', 'label' => 'Documents Résidence', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                        ['route' => 'resident.announcements', 'label' => 'Annonces & Infos', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>'],
                        ['route' => 'resident.notifications', 'label' => 'Notifications', 'badge' => $residentNotificationCount, 'badgeId' => 'resident-notification-count', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>'],
                    ];
                @endphp

                @foreach ($residentItems as $item)
                    @php
                        $isActive = request()->routeIs($item['route']);
                    @endphp
                    <a 
                        href="{{ route($item['route']) }}" 
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group {{ $isActive ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
                    >
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 transition-colors {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $item['icon'] !!}
                            </svg>
                            <span>{{ $item['label'] }}</span>
                        </div>
                        @if (isset($item['badge']))
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $isActive ? 'bg-white/20 text-white' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' }}">
                                <span id="{{ $item['badgeId'] ?? '' }}">{{ $item['badge'] }}</span>
                            </span>
                        @endif
                    </a>
                @endforeach
            </nav>

            <!-- Resident Footer Profile -->
            <div class="p-4 border-t border-slate-800 bg-slate-950/40">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="w-9 h-9 rounded-full bg-emerald-500/20 border border-emerald-500/30 text-emerald-300 font-semibold flex items-center justify-center text-sm shrink-0">
                            {{ strtoupper(substr(Auth::user()->name ?? 'R', 0, 2)) }}
                        </div>
                        <div class="truncate">
                            <span class="text-xs font-semibold text-white block truncate">{{ Auth::user()->name ?? 'Résident' }}</span>
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

        <!-- Main Content Area Resident -->
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
                        <h1 class="text-lg font-bold text-slate-900 tracking-tight">{{ $header ?? 'Espace Résident' }}</h1>
                        <p class="text-xs text-slate-500 hidden sm:block">Résidence Les Palmiers — Casablanca</p>
                    </div>
                </div>

                <!-- Right Action Buttons -->
                <div class="flex items-center gap-4">
                    <!-- Notification Button Demo -->
                    <div class="relative">
                        <button class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-xl relative transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span id="resident-header-notification-count" class="absolute top-1.5 right-1.5 min-w-2.5 h-2.5 rounded-full bg-emerald-500 ring-2 ring-white text-[9px] text-white text-center">{{ $residentNotificationCount }}</span>
                        </button>
                    </div>

                    <!-- Profile Avatar -->
                    <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
                        <div class="w-10 h-10 rounded-xl bg-emerald-700 text-white font-bold flex items-center justify-center shadow-xs">
                            {{ strtoupper(substr(Auth::user()->name ?? 'R', 0, 2)) }}
                        </div>
                        <div class="hidden lg:block text-left">
                            <span class="text-sm font-bold text-slate-900 block leading-tight">{{ Auth::user()->name ?? 'Résident' }}</span>
                            <span class="text-xs text-slate-500 block">Copropriétaire</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Scrollable Page Body Resident -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8 space-y-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
<script>
    (() => {
        const countUrl = @json(route('resident.notifications.count'));
        const updateCount = () => fetch(countUrl, { headers: { 'Accept': 'application/json' } })
            .then(response => response.json())
            .then(({ count }) => {
                document.querySelectorAll('#resident-notification-count, #resident-header-notification-count').forEach((element) => {
                    element.textContent = count;
                });
            })
            .catch(() => {});
        setInterval(updateCount, 5000);
    })();
</script>
