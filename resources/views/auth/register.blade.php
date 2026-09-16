<x-guest-layout>
    <!-- Header Title -->
    <div class="mb-6 text-center">
        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Inscription & Création de Compte</h2>
        <p class="text-xs text-slate-500 mt-1">Rejoignez l'espace numérique de votre résidence</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Full Name -->
        <x-form-group label="Nom complet" name="name" required>
            <x-input
                id="name"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                placeholder="Ex: Youssef El Mansouri"
                icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'
            />
        </x-form-group>

        <!-- Email Address -->
        <x-form-group label="Adresse Email" name="email" required>
            <x-input
                id="email"
                type="email"
                name="email"
                :value="old('email')"
                required
                placeholder="exemple@gmail.com"
                icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>'
            />
        </x-form-group>

        <!-- Phone Number -->
        <x-form-group label="Numéro de Téléphone" name="phone">
            <x-input
                id="phone"
                type="tel"
                name="phone"
                :value="old('phone')"
                placeholder="+212 6 00 00 00 00"
                icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>'
            />
        </x-form-group>

        <!-- Role Selection Cards -->
        <div x-data="{ currentRole: '{{ old('role', 'resident') }}' }" class="space-y-4">
            <x-form-group label="Votre Rôle dans la Résidence" name="role" required>
                <div class="grid grid-cols-2 gap-3">
                    <label 
                        @click="currentRole = 'resident'" 
                        :class="currentRole === 'resident' ? 'border-brand-500 bg-brand-50/50 ring-2 ring-brand-500/20' : 'border-slate-200 bg-white'"
                        class="flex flex-col items-center justify-center p-3 rounded-2xl border cursor-pointer transition text-center"
                    >
                        <input type="radio" name="role" value="resident" class="sr-only" x-model="currentRole">
                        <svg class="w-6 h-6 mb-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="text-xs font-bold text-slate-900">Résident / Habitant</span>
                        <span class="text-[10px] text-slate-500 mt-0.5">Copropriétaire</span>
                    </label>

                    <label 
                        @click="currentRole = 'syndic'" 
                        :class="currentRole === 'syndic' ? 'border-brand-500 bg-brand-50/50 ring-2 ring-brand-500/20' : 'border-slate-200 bg-white'"
                        class="flex flex-col items-center justify-center p-3 rounded-2xl border cursor-pointer transition text-center"
                    >
                        <input type="radio" name="role" value="syndic" class="sr-only" x-model="currentRole">
                        <svg class="w-6 h-6 mb-1 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="text-xs font-bold text-slate-900">Syndic</span>
                        <span class="text-[10px] text-slate-500 mt-0.5">Administrateur</span>
                    </label>
                </div>
            </x-form-group>

            <!-- Nom de la Résidence (Obligatoire pour les 2 rôles) -->
            <x-form-group label="Nom de la Résidence" name="residence_name" required>
                <x-input
                    id="residence_name"
                    type="text"
                    name="residence_name"
                    :value="old('residence_name')"
                    required
                    placeholder="Nom exact de votre résidence"
                    icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>'
                />
            </x-form-group>

            <!-- Champs spécifiques Résident -->
            <div x-show="currentRole === 'resident'" class="space-y-4 pt-1">
                <x-form-group label="Nom de l'Immeuble / Bâtiment" name="building_name" required>
                    <x-input
                        id="building_name"
                        type="text"
                        name="building_name"
                        :value="old('building_name')"
                        placeholder="Nom exact du bâtiment"
                        icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>'
                    />
                </x-form-group>

                <div class="grid grid-cols-2 gap-3">
                    <x-form-group label="N° Appartement" name="apartment_number" required>
                        <x-input
                            id="apartment_number"
                            type="text"
                            name="apartment_number"
                            :value="old('apartment_number')"
                            placeholder="Ex: 14"
                        />
                    </x-form-group>

                    <x-form-group label="Étage" name="floor" required>
                        <x-input
                            id="floor"
                            type="number"
                            name="floor"
                            :value="old('floor', 1)"
                            placeholder="Ex: 3"
                        />
                    </x-form-group>
                </div>
            </div>
        </div>

        <!-- Password -->
        <x-form-group label="Mot de passe" name="password" required>
            <x-input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>'
            />
        </x-form-group>

        <!-- Confirm Password -->
        <x-form-group label="Confirmer le mot de passe" name="password_confirmation" required>
            <x-input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>'
            />
        </x-form-group>

        <!-- Submit Button -->
        <div class="pt-2">
            <x-button variant="primary" type="submit" size="lg" class="w-full">
                Créer Mon Compte
            </x-button>
        </div>
    </form>

    <!-- Login Redirect Link -->
    <div class="mt-6 text-center text-xs text-slate-500">
        Vous avez déjà un compte ?
        <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:text-brand-800 hover:underline">
            Se connecter
        </a>
    </div>
</x-guest-layout>
