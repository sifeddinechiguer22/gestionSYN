import React, { useState } from 'react';
import {
  Code,
  Copy,
  Check,
  X,
  FileCode,
  Layers,
  FileText
} from 'lucide-react';

interface BladeCodeModalProps {
  isOpen: boolean;
  onClose: () => void;
}

export const BladeCodeModal: React.FC<BladeCodeModalProps> = ({
  isOpen,
  onClose,
}) => {
  const [activeSnippet, setActiveSnippet] = useState<'syndic' | 'resident' | 'auth' | 'table'>('syndic');
  const [copied, setCopied] = useState(false);

  if (!isOpen) return null;

  const snippets = {
    syndic: `{{-- resources/views/layouts/syndic.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SyndicPro - Administration' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full antialiased font-sans text-slate-800" x-data="{ mobileSidebarOpen: false }">

    {{-- Overlay mobile --}}
    <div x-show="mobileSidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileSidebarOpen = false" 
         class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-xs lg:hidden">
    </div>

    {{-- Sidebar Fixe Syndic --}}
    <aside id="syndic-sidebar" 
           :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed top-0 bottom-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 flex flex-col border-r border-slate-800 transition-transform duration-300 ease-in-out lg:translate-x-0">
        
        {{-- Logo Brand --}}
        <div class="h-16 flex items-center justify-between px-5 border-b border-slate-800 bg-slate-950/40">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-600 to-sky-500 flex items-center justify-center text-white font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <span class="font-bold text-white text-base">SyndicPro</span>
                    <span class="text-xs text-slate-400 block">{{ $residenceName ?? 'Jardins d\'Atlas' }}</span>
                </div>
            </div>
            <button @click="mobileSidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                ✕
            </button>
        </div>

        {{-- Navigation Blade --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <x-nav-link href="{{ route('syndic.dashboard') }}" :active="request()->routeIs('syndic.dashboard')">
                Dashboard
            </x-nav-link>
            <x-nav-link href="{{ route('syndic.residents.index') }}" :active="request()->routeIs('syndic.residents.*')" badge="84">
                Résidents
            </x-nav-link>
            <x-nav-link href="{{ route('syndic.payments.index') }}" :active="request()->routeIs('syndic.payments.*')">
                Paiements
            </x-nav-link>
            <x-nav-link href="{{ route('syndic.complaints.index') }}" :active="request()->routeIs('syndic.complaints.*')" badge="4" badgeColor="bg-rose-500">
                Réclamations
            </x-nav-link>
            <x-nav-link href="{{ route('syndic.announcements.index') }}" :active="request()->routeIs('syndic.announcements.*')">
                Annonces
            </x-nav-link>
        </nav>

        {{-- Profil bas de sidebar --}}
        <div class="p-3 border-t border-slate-800 bg-slate-950/40 flex items-center justify-between">
            <div class="flex items-center space-x-3 truncate">
                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs">SY</div>
                <div class="truncate">
                    <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name ?? 'Admin Syndic' }}</p>
                    <p class="text-[11px] text-slate-400">Bureau Gestionnaire</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-slate-400 hover:text-rose-400 p-1">Déconnexion</button>
            </form>
        </div>
    </aside>

    {{-- Main Container (Sidebar offset lg:pl-64) --}}
    <div class="lg:pl-64 flex flex-col min-h-screen">
        {{-- Navbar Top --}}
        <header class="sticky top-0 z-30 h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between shadow-xs">
            <div class="flex items-center space-x-3">
                <button @click="mobileSidebarOpen = true" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <span class="text-xs font-semibold text-slate-700 bg-slate-100 px-3 py-1 rounded-full">
                    {{ $residenceName ?? 'Résidence Les Jardins d’Atlas' }}
                </span>
            </div>

            <div class="flex items-center space-x-3">
                <x-notifications-dropdown />
                <x-user-dropdown />
            </div>
        </header>

        {{-- Main View Slot --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </main>
    </div>
</body>
</html>`,

    resident: `{{-- resources/views/layouts/resident.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Espace Résident' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full antialiased font-sans text-slate-800" x-data="{ mobileSidebarOpen: false }">

    {{-- Sidebar Résident --}}
    <aside id="resident-sidebar" 
           :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed top-0 bottom-0 left-0 z-50 w-64 bg-slate-900 text-slate-200 flex flex-col border-r border-emerald-950/40 transition-transform duration-300 ease-in-out lg:translate-x-0">
        
        {{-- En-tête avec badge Résident --}}
        <div class="h-16 flex items-center justify-between px-5 border-b border-slate-800 bg-emerald-950/30">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-bold">
                    🔑
                </div>
                <div>
                    <span class="font-bold text-white text-base">Espace Résident</span>
                    <span class="text-xs text-emerald-400 block">Jardins d'Atlas</span>
                </div>
            </div>
        </div>

        {{-- Lot assigné badge --}}
        <div class="px-4 py-3 border-b border-slate-800/80 bg-slate-900/60">
            <div class="p-2.5 rounded-xl bg-slate-800/90 border border-emerald-500/20 text-xs">
                <span class="text-slate-400 text-[11px]">Mon Logement</span>
                <p class="font-bold text-white text-sm mt-0.5">{{ auth()->user()->apartment ?? 'Bâtiment B • Apt B-204' }}</p>
            </div>
        </div>

        {{-- Liens de navigation Résident --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <x-nav-link href="{{ route('resident.dashboard') }}" :active="request()->routeIs('resident.dashboard')">
                Dashboard
            </x-nav-link>
            <x-nav-link href="{{ route('resident.apartment') }}" :active="request()->routeIs('resident.apartment')">
                Mon appartement
            </x-nav-link>
            <x-nav-link href="{{ route('resident.payments') }}" :active="request()->routeIs('resident.payments')">
                Mes paiements
            </x-nav-link>
            <x-nav-link href="{{ route('resident.complaints') }}" :active="request()->routeIs('resident.complaints')">
                Mes réclamations
            </x-nav-link>
            <x-nav-link href="{{ route('resident.documents') }}" :active="request()->routeIs('resident.documents')">
                Documents
            </x-nav-link>
            <x-nav-link href="{{ route('resident.announcements') }}" :active="request()->routeIs('resident.announcements')">
                Annonces
            </x-nav-link>
        </nav>
    </aside>

    {{-- Contenu Principal --}}
    <div class="lg:pl-64 flex flex-col min-h-screen">
        <header class="sticky top-0 z-30 h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between">
            <button @click="mobileSidebarOpen = true" class="lg:hidden p-2 rounded-lg text-slate-600">☰</button>
            <span class="text-xs font-semibold bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full border border-emerald-200">
                Lot B-204 • Copropriétaire
            </span>
        </header>

        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </main>
    </div>
</body>
</html>`,

    auth: `{{-- resources/views/layouts/auth.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Connexion - SyndicPro' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-slate-900 text-slate-200 relative overflow-hidden">
    {{-- Gradient de fond --}}
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 text-center">
        <div class="w-14 h-14 mx-auto rounded-2xl bg-gradient-to-tr from-indigo-600 to-sky-500 flex items-center justify-center text-white shadow-xl">
            🏢
        </div>
        <h2 class="mt-4 text-2xl font-extrabold text-white">SyndicPro</h2>
        <p class="text-sm text-slate-400 mt-1">Accès copropriétaires et administration</p>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-md relative z-10">
        <div class="bg-slate-800/70 backdrop-blur-md py-8 px-6 shadow-2xl border border-slate-700/80 sm:rounded-2xl sm:px-10">
            {{ $slot }}
        </div>
    </div>
</body>
</html>`,

    table: `{{-- resources/views/components/table/resident-row.blade.php --}}
<tr class="hover:bg-slate-50/70 transition-colors">
    <td class="py-3.5 px-4">
        <div class="flex items-center space-x-3">
            <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs">
                {{ substr($resident->first_name, 0, 1) }}{{ substr($resident->last_name, 0, 1) }}
            </div>
            <div>
                <div class="font-bold text-slate-900 text-xs">{{ $resident->name }}</div>
                <div class="text-[11px] text-slate-400">{{ $resident->phone }}</div>
            </div>
        </div>
    </td>
    <td class="py-3.5 px-3">
        <span class="px-2 py-0.5 rounded bg-slate-100 font-mono font-bold text-slate-800">
            {{ $resident->apartment->code }}
        </span>
    </td>
    <td class="py-3.5 px-3 font-bold text-slate-900">
        {{ number_format($resident->monthly_due, 0, ',', ' ') }} MAD
    </td>
    <td class="py-3.5 px-3">
        @if($resident->is_up_to_date)
            <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                À jour
            </span>
        @else
            <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                Impayé ({{ number_format($resident->unpaid_amount, 0, ',', ' ') }} MAD)
            </span>
        @endif
    </td>
</tr>`
  };

  const handleCopy = () => {
    navigator.clipboard.writeText(snippets[activeSnippet]);
    setCopied(true);
    setTimeout(() => setCopied(false), 2000);
  };

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs">
      <div className="bg-slate-900 text-white rounded-2xl shadow-2xl max-w-3xl w-full overflow-hidden border border-slate-700 flex flex-col max-h-[85vh] animate-in fade-in zoom-in-95 duration-150">
        {/* Header */}
        <div className="px-6 py-4 border-b border-slate-800 flex items-center justify-between">
          <div className="flex items-center space-x-2">
            <FileCode className="w-5 h-5 text-indigo-400" />
            <div>
              <h3 className="text-base font-bold text-white">Modèles Blade (Laravel 11 + Tailwind)</h3>
              <p className="text-xs text-slate-400">Code prêt pour vos fichiers .blade.php</p>
            </div>
          </div>
          <button onClick={onClose} className="p-1 rounded-lg text-slate-400 hover:text-white">
            <X className="w-5 h-5" />
          </button>
        </div>

        {/* Tab switcher */}
        <div className="flex bg-slate-950/60 p-2 border-b border-slate-800 gap-2 overflow-x-auto text-xs">
          <button
            onClick={() => setActiveSnippet('syndic')}
            className={`px-3 py-1.5 rounded-lg font-semibold whitespace-nowrap transition-all ${
              activeSnippet === 'syndic' ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-slate-200'
            }`}
          >
            layouts/syndic.blade.php
          </button>
          <button
            onClick={() => setActiveSnippet('resident')}
            className={`px-3 py-1.5 rounded-lg font-semibold whitespace-nowrap transition-all ${
              activeSnippet === 'resident' ? 'bg-emerald-600 text-white' : 'text-slate-400 hover:text-slate-200'
            }`}
          >
            layouts/resident.blade.php
          </button>
          <button
            onClick={() => setActiveSnippet('auth')}
            className={`px-3 py-1.5 rounded-lg font-semibold whitespace-nowrap transition-all ${
              activeSnippet === 'auth' ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-slate-200'
            }`}
          >
            layouts/auth.blade.php
          </button>
          <button
            onClick={() => setActiveSnippet('table')}
            className={`px-3 py-1.5 rounded-lg font-semibold whitespace-nowrap transition-all ${
              activeSnippet === 'table' ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-slate-200'
            }`}
          >
            table/resident-row.blade.php
          </button>
        </div>

        {/* Code body */}
        <div className="p-4 flex-1 overflow-y-auto bg-slate-950 font-mono text-xs text-slate-300 leading-relaxed custom-scrollbar">
          <pre className="whitespace-pre-wrap">{snippets[activeSnippet]}</pre>
        </div>

        {/* Footer */}
        <div className="p-4 border-t border-slate-800 bg-slate-900 flex items-center justify-between">
          <span className="text-xs text-slate-400">Compatible Laravel 11, Alpine.js et Vite</span>
          <button
            onClick={handleCopy}
            className="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white shadow-xs transition-colors"
          >
            {copied ? <Check className="w-4 h-4 text-emerald-300" /> : <Copy className="w-4 h-4" />}
            <span>{copied ? 'Code copié !' : 'Copier le code Blade'}</span>
          </button>
        </div>
      </div>
    </div>
  );
};
