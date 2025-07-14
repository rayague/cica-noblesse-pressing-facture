<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Commande;

echo "=== TEST RECHERCHE SIMULÉE ===\n\n";

// Test avec un numéro qui n'existe pas
$numeroTest = "12345678";
echo "Test avec le numéro: '{$numeroTest}'\n";

// Nettoyer le numéro saisi
$numero = preg_replace('/[^0-9]/', '', $numeroTest);
echo "Numéro nettoyé: '{$numero}'\n";

// Si le numéro fait plus de 8 chiffres, prendre les 8 derniers
if (strlen($numero) > 8) {
    $numero = substr($numero, -8);
    echo "8 derniers chiffres: '{$numero}'\n";
}

// Chercher avec plusieurs patterns possibles (comme dans le contrôleur)
$commande = Commande::where(function($query) use ($numero) {
    $query->where('numero_whatsapp', 'LIKE', '%' . $numero . '%')
          ->orWhere('numero_whatsapp', 'LIKE', '%' . substr($numero, -7) . '%')
          ->orWhere('numero_whatsapp', 'LIKE', '%' . substr($numero, -6) . '%');
})
->whereNotNull('password_client')
->first();

if ($commande) {
    echo "✓ Trouvé: ID {$commande->id} | Numéro: '{$commande->numero_whatsapp}' | Client: {$commande->client}\n";
} else {
    echo "✗ Non trouvé - C'est normal pour ce test\n";

    // Debug: afficher tous les numéros pour voir
    echo "\nNuméros disponibles dans la base:\n";
    $tous = Commande::whereNotNull('password_client')->get();
    foreach ($tous as $cmd) {
        echo "- '{$cmd->numero_whatsapp}' (Client: {$cmd->client})\n";
    }
}

echo "\n=== FIN TEST ===\n";
