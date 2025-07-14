<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Commande;

echo "=== DÉBOGAGE DE LA VÉRIFICATION DU NUMÉRO ===\n\n";

// Test avec le numéro de test
$numeroTest = '23244566';
echo "Numéro de test: " . $numeroTest . "\n\n";

// 1. Test de nettoyage
$numeroNettoye = preg_replace('/[^0-9]/', '', $numeroTest);
echo "1. Nettoyage du numéro:\n";
echo "   - Original: " . $numeroTest . "\n";
echo "   - Nettoyé: " . $numeroNettoye . "\n\n";

// 2. Test de recherche sans condition password_client
echo "2. Recherche SANS condition password_client:\n";
$commandesSansPassword = Commande::where('numero_whatsapp', 'LIKE', '%' . $numeroNettoye . '%')->get();
echo "   - Nombre de commandes trouvées: " . $commandesSansPassword->count() . "\n";

if ($commandesSansPassword->count() > 0) {
    foreach ($commandesSansPassword as $commande) {
        echo "   - Commande ID: " . $commande->id . "\n";
        echo "     Client: " . $commande->client . "\n";
        echo "     WhatsApp: " . $commande->numero_whatsapp . "\n";
        echo "     Password_client: " . ($commande->password_client ? "PRÉSENT" : "ABSENT") . "\n";
        echo "     Hash: " . ($commande->password_client ? substr($commande->password_client, 0, 20) . "..." : "NULL") . "\n\n";
    }
}

// 3. Test de recherche AVEC condition password_client
echo "3. Recherche AVEC condition password_client:\n";
$commandesAvecPassword = Commande::where('numero_whatsapp', 'LIKE', '%' . $numeroNettoye . '%')
    ->whereNotNull('password_client')
    ->get();
echo "   - Nombre de commandes trouvées: " . $commandesAvecPassword->count() . "\n";

if ($commandesAvecPassword->count() > 0) {
    foreach ($commandesAvecPassword as $commande) {
        echo "   - Commande ID: " . $commande->id . "\n";
        echo "     Client: " . $commande->client . "\n";
        echo "     WhatsApp: " . $commande->numero_whatsapp . "\n";
        echo "     Hash: " . substr($commande->password_client, 0, 20) . "...\n\n";
    }
} else {
    echo "   - Aucune commande avec mot de passe trouvée!\n\n";
}

// 4. Test avec first() comme dans le contrôleur
echo "4. Test avec first() (comme dans le contrôleur):\n";
$commandeFirst = Commande::where('numero_whatsapp', 'LIKE', '%' . $numeroNettoye . '%')
    ->whereNotNull('password_client')
    ->first();

if ($commandeFirst) {
    echo "   - ✓ Commande trouvée avec first()\n";
    echo "     ID: " . $commandeFirst->id . "\n";
    echo "     Client: " . $commandeFirst->client . "\n";
} else {
    echo "   - ✗ Aucune commande trouvée avec first()\n";
}

echo "\n=== FIN DU DÉBOGAGE ===\n";
