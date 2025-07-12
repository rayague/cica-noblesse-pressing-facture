<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf
        <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">Créer un compte</h2>
        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
            <input id="name" class="mt-1 block w-full rounded-lg border border-blue-200 focus:border-blue-500 focus:ring focus:ring-blue-100 focus:ring-opacity-50 shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Entrez votre nom complet" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
            <input id="email" class="mt-1 block w-full rounded-lg border border-blue-200 focus:border-blue-500 focus:ring focus:ring-blue-100 focus:ring-opacity-50 shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Entrez votre e-mail" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
            <input id="password" class="mt-1 block w-full rounded-lg border border-blue-200 focus:border-blue-500 focus:ring focus:ring-blue-100 focus:ring-opacity-50 shadow-sm" type="password" name="password" required autocomplete="new-password" placeholder="Créez un mot de passe" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
            <input id="password_confirmation" class="mt-1 block w-full rounded-lg border border-blue-200 focus:border-blue-500 focus:ring focus:ring-blue-100 focus:ring-opacity-50 shadow-sm" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Répétez le mot de passe" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="flex items-center justify-between mt-4">
            <a class="text-sm text-blue-600 hover:underline" href="{{ route('login') }}">
                Déjà inscrit ? Se connecter
            </a>
            <button type="submit" class="py-3 px-6 bg-blue-600 text-white font-bold rounded-lg shadow hover:bg-blue-700 transition">Créer mon compte</button>
        </div>
    </form>
</x-guest-layout>
