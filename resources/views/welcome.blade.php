<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mes Factures - Cica Noblesse Pressing</title>
        <!-- DESCRIPTION LONGUE POUR GOOGLE -->
        <meta name="description"
        content="Cica est un service de lavage professionnel, rapide et efficace, conçu pour faciliter l'entretien de vos vêtements. Développé par Ray Ague, Cica garantit une propreté impeccable avec un service fiable et accessible en ligne. Essayez notre service dès aujourd'hui !">

    <!-- MOTS-CLÉS POUR GOOGLE -->
    <meta name="keywords"
        content="Lavage, pressing, blanchisserie, nettoyage, vêtements, service de lavage, lavage professionnel, Ray Ague, Cica, lessive écologique">

    <!-- NOM DE L'AUTEUR -->
    <meta name="author" content="Ray Ague">

    <!-- GOOGLE INDEXATION -->
    <meta name="robots" content="index, follow">

    <!-- OPEN GRAPH POUR FACEBOOK ET WHATSAPP -->
    <meta property="og:title" content="Cica - Service de lavage par Ray Ague">
    <meta property="og:description"
        content="Besoin d'un service de lavage rapide et efficace ? Cica, développé par Ray Ague, est la solution parfaite !">
    <meta property="og:image" content="{{ asset('images/Cica.png') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">

    <!-- TWITTER CARD POUR LE PARTAGE SUR TWITTER -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Cica - Lavage Professionnel">
    <meta name="twitter:description"
        content="Ray Ague présente Cica : un service de lavage rapide et fiable pour tous vos vêtements.">
    <meta name="twitter:image" content="{{ asset('images/Cica.png') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/Cica.png') }}" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body class="font-sans antialiased text-gray-900 bg-gray-100">
    <!-- Header avec logo -->
    <header class="absolute top-0 left-0 z-20 p-4 sm:p-6">
        <div class="flex items-center space-x-3">
            <img src="{{ asset(path: '/Cica.png') }}" alt="Logo Cica Noblesse Pressing" class="h-8 w-8 sm:h-10 sm:w-10 object-contain" />
            <span class="text-white font-bold text-lg sm:text-xl">Cica Noblesse Pressing</span>
                        </div>
    </header>

    <!-- Section principale -->
    <section class="min-h-screen flex flex-col items-center justify-center relative overflow-hidden bg-gradient-to-br from-blue-600 via-sky-500 to-yellow-500">
        <!-- Arrière-plan avec formes géométriques -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
                                        </div>

        <div class="w-full max-w-4xl px-6 text-center py-8 sm:py-20 relative z-10">
            <h1 class="w-full text-3xl sm:text-5xl md:text-7xl font-extrabold mb-4 sm:mb-8 leading-tight text-white drop-shadow-lg">
                <span class="block w-full">Consultez vos factures</span>
                <span class="block w-full bg-gradient-to-r from-white to-gray-100 bg-clip-text text-transparent drop-shadow-lg">
                    en toute simplicité
                </span>
            </h1>

            <p class="text-lg sm:text-xl md:text-2xl text-white/90 mb-6 sm:mb-12 max-w-3xl mx-auto leading-relaxed">
                Accédez facilement à toutes vos factures de pressing avec votre numéro de téléphone.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 justify-center items-center">
                <a href="{{ route('client.login') }}" class="px-6 sm:px-8 py-2.5 sm:py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-full font-bold text-sm sm:text-base hover:from-green-600 hover:to-emerald-700 transition-all duration-300 flex items-center space-x-2 shadow-lg">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Consulter mes factures</span>
                </a>
                                </div>
                </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 w-full">
      <div class="max-w-2xl mx-auto px-4 text-center">
        <p class="font-bold text-lg mb-1">
          Developed by <span class="text-blue-400">Ray Ague</span>
        </p>
        <p class="text-sm">
          Project Manager and Business Development Analyst:
          <span class="font-semibold" style="color: #F59E0B">Abdalah KH AGUESSY-VOGNON</span>
        </p>
      </div>
    </footer>
    </body>
</html>
