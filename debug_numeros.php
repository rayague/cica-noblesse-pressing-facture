<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Commande;

echo "=== DEBUG NUMÉROS DE TÉLÉPHONE ===\n\n";

// Afficher tous les numéros avec password_client
echo "Commandes avec password_client:\n";
$commandes = Commande::whereNotNull('password_client')->get();

foreach ($commandes as $commande) {
    echo "ID: {$commande->id} | Numéro: '{$commande->numero_whatsapp}' | Client: {$commande->client}\n";
}

echo "\n=== TEST DE RECHERCHE ===\n";

// Test avec un numéro (remplacez par un numéro réel de votre base)
if (count($commandes) > 0) {
    $testNumero = $commandes->first()->numero_whatsapp;
    echo "Test avec le numéro: '{$testNumero}'\n";

    // Nettoyer le numéro
    $numeroClean = preg_replace('/[^0-9]/', '', $testNumero);
    echo "Numéro nettoyé: '{$numeroClean}'\n";

    if (strlen($numeroClean) > 8) {
        $numero8 = substr($numeroClean, -8);
        echo "8 derniers chiffres: '{$numero8}'\n";
    }

    // Test de recherche
    $resultat = Commande::where('numero_whatsapp', 'LIKE', '%' . $numeroClean . '%')
        ->whereNotNull('password_client')
        ->first();

    if ($resultat) {
        echo "✓ Trouvé: {$resultat->numero_whatsapp}\n";
    } else {
        echo "✗ Non trouvé\n";
    }
}

echo "\n=== FIN DEBUG ===\n";
