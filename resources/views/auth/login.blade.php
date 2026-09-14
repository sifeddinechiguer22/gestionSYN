<x-guest-layout>
    <!-- Header Title -->
    <div class="mb-6 text-center">
        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Connexion à votre Espace</h2>
        <p class="text-xs text-slate-500 mt-1">Accédez au portail de votre copropriété (Syndic ou Résident)</p>
    </div>

    <!-- Session Status Flash Alert -->
    @if (session('status'))
        <div class="mb-4 text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 p-3 rounded-xl">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5" id="loginForm">
        @csrf

        <!-- Email Address -->
        <x-form-group label="Adresse Email" name="email" required>
            <x-input
                id="email"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                placeholder="exemple@gmail.com"
                icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>'
            />
        </x-form-group>

        <!-- Password -->
        <x-form-group label="Mot de passe" name="password" required>
            <x-input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
                icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>'
            />
        </x-form-group>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-xs">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded-md border-slate-300 text-brand-600 shadow-xs focus:ring-brand-500"
                    name="remember"
                >
                <span class="ms-2 text-slate-600 font-medium">Se souvenir de moi</span>
            </label>

            @if (Route::has('password.request'))
                <a class="font-semibold text-brand-600 hover:text-brand-800 hover:underline" href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <x-button variant="primary" type="submit" size="lg" class="w-full">
                Se Connecter
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </x-button>
        </div>
    </form>

    <!-- Register Redirect Link -->
    <div class="mt-6 text-center text-xs text-slate-500">
        Vous êtes un nouveau copropriétaire ?
        <a href="{{ route('register') }}" class="font-bold text-brand-600 hover:text-brand-800 hover:underline">
            Créer un compte
        </a>
    </div>
</x-guest-layout>
