<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">Connexion à votre espace</h2>
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
            <input id="email" class="mt-1 block w-full rounded-lg border border-blue-200 focus:border-blue-500 focus:ring focus:ring-blue-100 focus:ring-opacity-50 shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Entrez votre e-mail" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
            <input id="password" class="mt-1 block w-full rounded-lg border border-blue-200 focus:border-blue-500 focus:ring focus:ring-blue-100 focus:ring-opacity-50 shadow-sm" type="password" name="password" required autocomplete="current-password" placeholder="Entrez votre mot de passe" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>
        <div>
            <button type="submit" class="w-full py-3 px-4 bg-blue-600 text-white font-bold rounded-lg shadow hover:bg-blue-700 transition">Se connecter</button>
        </div>
        <div class="text-center text-sm text-gray-600 mt-4">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">Créer un compte</a>
        </div>
    </form>
</x-guest-layout>
