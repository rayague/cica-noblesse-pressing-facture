<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mes Factures - Cica Noblesse Pressing</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="shortcut icon" href="{{ asset('images/Cica.png') }}" type="image/x-icon">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center h-auto sm:h-16 py-4 sm:py-0 space-y-3 sm:space-y-0">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-lg sm:text-xl font-bold text-gray-900">Mes Factures</span>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                    <span class="text-sm text-gray-600">
                        Connecté en tant que <span class="font-semibold">{{ $clientInfo['nom'] }}</span>
                    </span>
                    <!-- Nouveau bouton de déconnexion -->
                    <button type="button" id="openLogoutModal" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                        </svg>
                        Déconnexion
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Modal de confirmation de déconnexion -->
    <div id="logoutModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm transition-opacity duration-200 hidden">
        <div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-2xl p-8 w-3/4 mx-4 relative animate-fade-in flex flex-col items-center">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 text-center">Confirmer la déconnexion</h2>
            <p class="text-gray-700 mb-6 text-center">Êtes-vous sûr de vouloir vous déconnecter&nbsp;?</p>
            <div class="flex flex-col sm:flex-row justify-center gap-3 w-full mt-2">
                <button id="cancelLogout" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition w-full sm:w-1/2">Annuler</button>
                <form method="POST" action="{{ route('client.logout') }}" class="w-full sm:w-1/2">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">Confirmer</button>
                </form>
            </div>

        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(30px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .animate-fade-in { animation: fade-in 0.25s cubic-bezier(.4,0,.2,1); }
        body.modal-open { overflow: hidden; }
    </style>

    <script>
        const logoutModal = document.getElementById('logoutModal');
        const openBtn = document.getElementById('openLogoutModal');
        const cancelBtn = document.getElementById('cancelLogout');
        const closeBtn = document.getElementById('closeLogoutModal');

        openBtn.onclick = function() {
            logoutModal.classList.remove('hidden');
            document.body.classList.add('modal-open');
        };
        cancelBtn.onclick = closeBtn.onclick = function() {
            logoutModal.classList.add('hidden');
            document.body.classList.remove('modal-open');
        };
        // Fermer le modal si on clique en dehors du contenu
        logoutModal.onclick = function(e) {
            if (e.target === logoutModal) {
                logoutModal.classList.add('hidden');
                document.body.classList.remove('modal-open');
            }
        };
    </script>

    <!-- Contenu principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistiques -->
        <div class="flex flex-row flex-nowrap gap-6 mb-8 overflow-x-auto">
            <div class="flex-1 min-w-[250px] bg-white rounded-xl p-6 shadow-sm border flex flex-col items-center justify-center">
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-sm font-medium text-gray-600">Total Factures</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalCommandes }}</p>
                    </div>
                </div>
            </div>

            <div class="flex-1 min-w-[250px] bg-white rounded-xl p-6 shadow-sm border flex flex-col items-center justify-center">
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-sm font-medium text-gray-600">En Cours</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $commandesEnCours }}</p>
                    </div>
                </div>
            </div>

            <div class="flex-1 min-w-[250px] bg-white rounded-xl p-6 shadow-sm border flex flex-col items-center justify-center">
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-sm font-medium text-gray-600">Terminées</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $commandesTerminees }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des factures -->
        <div class="bg-white rounded-xl shadow-sm border">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Vos Factures</h2>
                <p class="text-sm text-gray-600 mt-1">Retrouvez toutes vos factures de pressing</p>
            </div>

            @if($commandes->isEmpty())
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune facture trouvée</h3>
                    <p class="text-gray-600">Vous n'avez pas encore de factures dans notre système.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                    @foreach($commandes as $commande)
                        <div class="bg-white rounded-xl shadow-sm border p-6 flex flex-col justify-between h-full">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-semibold text-gray-500">N° Commande</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $commande->numero }}</span>
                                </div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-semibold text-gray-500">Date</span>
                                    <span class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($commande->created_at)->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-semibold text-gray-500">Heure</span>
                                    <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($commande->created_at)->format('H:i') }}</span>
                                </div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-semibold text-gray-500">Montant</span>
                                    <span class="text-sm font-bold text-gray-900">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</span>
                                </div>
                                @if($commande->avance_client > 0)
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-semibold text-gray-500">Acompte</span>
                                        <span class="text-xs text-gray-500">{{ number_format($commande->avance_client, 0, ',', ' ') }} FCFA</span>
                                    </div>
                                @endif
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xs font-semibold text-gray-500">Statut</span>
                                    @if($commande->statut === 'Retiré')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Retiré</span>
                                    @elseif($commande->statut === 'Partiellement payé')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Partiellement payé</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">En attente</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2 mt-4">
                                <a href="{{ route('client.factures.download', $commande->id) }}"
                                   class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors w-full sm:w-auto">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Télécharger
                                </a>
                                @php
                                    $numeroPressing = '229XXXXXXXX'; // Remplace par le vrai numéro WhatsApp du pressing
                                    $message = rawurlencode(
                                        'Bonjour,\nJe souhaite avoir des informations sur ma facture #' . ($commande->numero ?? '') . ' du ' . (\Carbon\Carbon::parse($commande->created_at)->format('d/m/Y')) . '.\nMerci.'
                                    );
                                @endphp
                                <a href="https://wa.me/{{ $numeroPressing }}?text={{ $message }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors w-full sm:w-auto">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V10a2 2 0 012-2h2m4-4h4a2 2 0 012 2v4a2 2 0 01-2 2h-4a2 2 0 01-2-2V6a2 2 0 012-2z" />
                                    </svg>
                                    WhatsApp
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Informations supplémentaires -->
        <div class="mt-8 bg-blue-50 rounded-xl p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-900">Informations importantes</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Vos factures sont générées automatiquement à partir de vos commandes</li>
                            <li>Vous pouvez télécharger vos factures en format PDF</li>
                            <li>Pour toute question, contactez-nous au {{ $clientInfo['numero_whatsapp'] }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 mt-12">
      <div class="max-w-2xl mx-auto px-4 text-center">
        <p class="font-bold text-lg mb-1">
          Developed by <a href="https://www.linkedin.com/in/ray-ague-2066b4247/" target="_blank" rel="noopener" class="text-blue-400 underline hover:text-blue-300">Ray Ague</a>
        </p>
        <p class="text-sm">
          Project Manager and Business Development Analyst:
          <a href="https://www.linkedin.com/in/abdalah-aguessy-vognon?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=ios_app" target="_blank" rel="noopener" class="font-semibold" style="color: #F59E0B; text-decoration: underline;">Abdalah KH AGUESSY-VOGNON</a>
        </p>
      </div>
    </footer>
</body>
</html>
