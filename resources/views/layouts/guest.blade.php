<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-pattern">
        <!-- Navbar -->
        <nav class="w-full z-50 bg-white shadow">
            <div class="container mx-auto px-4 sm:px-6 flex items-center justify-between h-16 sm:h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <a href="/" class="flex items-center">
                        <div class="  rounded-full flex items-center justify-center">
                            <img src="{{ asset(path: '/Cica.png') }}" alt="Logo Cica Noblesse Pressing" class="w-20 h-20 object-contain mx-auto" />
                        </div>
                        <span class="ml-3 text-xl sm:text-2xl font-bold text-yellow-400">Cica <span class="text-yellow-400">Noblesse Pressing</span></span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-300">Accueil</a>
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition-all duration-300 hover:scale-105">Se connecter</a>
                </div>
            </div>
        </nav>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="/">
                    <img src="{{ asset(path: '/Cica.png') }}" alt="Logo Cica Noblesse Pressing" class="w-20 h-20 object-contain mx-auto" />
                </a>
            </div>
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white/90 shadow-xl overflow-hidden sm:rounded-2xl border border-blue-100">
                {{ $slot }}
            </div>
        </div>
        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-8 mt-12">
            <div class="container mx-auto px-4 text-center">
                <h3 class="text-2xl font-bold mb-2">
                    <span class="text-blue-400">Cica</span> <span class="text-yellow-400">Noblesse</span>
                </h3>
                <p class="text-gray-400 mb-2">Votre pressing de confiance</p>
                <p class="text-sm text-gray-500">© 2024 Cica Noblesse Pressing. Tous droits réservés.<br>
                    Réalisé par <a href="https://portfolio-cnkp.vercel.app" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-500 text-yellow-400 transition-colors font-semibold">Ray Ague</a>
                </p>
            </div>
        </footer>
    </body>
</html>
