<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consultation Factures - Cica Noblesse Pressing</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gradient-to-br from-blue-600 via-sky-500 to-yellow-500 min-h-screen">
    <!-- Header avec logo -->
    <header class="absolute top-0 left-0 z-20 p-4 sm:p-6">
        <div class="flex items-center space-x-3">
            <img src="{{ asset(path: '/Cica.png') }}" alt="Logo Cica Noblesse Pressing" class="h-8 w-8 sm:h-10 sm:w-10 object-contain" />
            <span class="text-white font-bold text-lg sm:text-xl">Cica Noblesse Pressing</span>
        </div>
    </header>

    <div class="min-h-screen flex flex-col items-center justify-center relative overflow-hidden">
        <!-- Arrière-plan avec formes géométriques -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full max-w-md px-6 relative z-10">
            <!-- Logo et titre -->
            <div class="text-center mb-8 mt-20">

                <h1 class="text-3xl font-bold text-white mb-2">Consultation Factures</h1>
                <p class="text-white/80">Accédez à vos factures avec votre numéro de téléphone</p>
            </div>

            <!-- Formulaire de connexion -->
            <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-8 shadow-2xl border border-white/30">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-500/20 border border-red-500/30 rounded-lg">
                        <div class="text-red-200 text-sm">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('client.login.post') }}" class="space-y-6">
                    @csrf

                    <!-- Numéro de téléphone -->
                    <div>
                        <label for="numero_whatsapp" class="block text-sm font-semibold text-white mb-2">
                            Numéro de téléphone
                        </label>
                        <input id="numero_whatsapp"
                               type="tel"
                               name="numero_whatsapp"
                               value="{{ old('numero_whatsapp') }}"
                               required
                               autofocus
                               class="w-full px-4 py-3 border border-white/30 rounded-lg bg-white/10 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent backdrop-blur-sm"
                               placeholder="Ex: 97000000">
                        <p class="mt-1 text-xs text-white/60">Entrez le numéro utilisé lors de vos commandes</p>
                    </div>

                    <!-- Bouton de connexion -->
                    <button type="submit"
                            class="w-full px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-bold text-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:scale-105 shadow-2xl hover:shadow-green-500/25 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Consulter mes factures</span>
                    </button>
                </form>

                <!-- Informations -->
                <div class="mt-6 text-center">
                    <p class="text-white/70 text-sm">
                        En utilisant ce service, vous acceptez que nous vérifions votre numéro
                        pour vous donner accès à vos factures.
                    </p>
                </div>
            </div>

            <!-- Lien vers l'accueil -->
            <div class="text-center my-10">
                <a href="/" class="inline-flex items-center space-x-2 px-6 py-3 bg-white/10 backdrop-blur-lg text-white rounded-xl font-semibold hover:bg-white/20 transition-all duration-300 transform hover:scale-105 shadow-lg border border-white/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Retour à l'accueil</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 w-full mt-auto">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-2xl font-bold mb-2">
                <span class="text-blue-400">Cica</span> <span class="text-yellow-400">Noblesse Pressing</span>
            </h3>
            <p class="text-gray-400 mb-2">Votre pressing de confiance</p>
            <p class="text-sm text-gray-500">© 2025 Cica Noblesse Pressing. Tous droits réservés.<br>
                Réalisé par <a href="https://portfolio-cnkp.vercel.app" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-500 text-yellow-400 transition-colors font-semibold">Ray Ague</a>
            </p>
        </div>
    </footer>
</body>
</html>
