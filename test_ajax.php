<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Commande;
use Illuminate\Http\Request;

echo "=== TEST SIMULATION AJAX ===\n\n";

// Simuler une requête AJAX
$request = new Request();
$request->merge(['numero_whatsapp' => '23244566']);

echo "Données de la requête simulée:\n";
echo "- numero_whatsapp: " . $request->numero_whatsapp . "\n\n";

// Validation
$request->validate([
    'numero_whatsapp' => 'required|string|min:8',
]);

echo "✓ Validation réussie\n\n";

// Nettoyer le numéro de téléphone
$numero = preg_replace('/[^0-9]/', '', $request->numero_whatsapp);
echo "Numéro nettoyé: " . $numero . "\n\n";

// Chercher les commandes avec ce numéro
$commandes = Commande::where('numero_whatsapp', 'LIKE', '%' . $numero . '%')
    ->whereNotNull('password_client')
    ->first();

echo "Résultat de la recherche:\n";
if ($commandes) {
    echo "✓ Commande trouvée!\n";
    echo "- ID: " . $commandes->id . "\n";
    echo "- Client: " . $commandes->client . "\n";
    echo "- WhatsApp: " . $commandes->numero_whatsapp . "\n";
    echo "- Password_client: " . ($commandes->password_client ? "PRÉSENT" : "ABSENT") . "\n\n";

    echo "Réponse JSON (succès):\n";
    echo json_encode([
        'success' => true,
        'message' => 'Numéro vérifié avec succès.'
    ], JSON_PRETTY_PRINT) . "\n";
} else {
    echo "✗ Aucune commande trouvée!\n\n";

    echo "Réponse JSON (échec):\n";
    echo json_encode([
        'success' => false,
        'message' => 'Aucune facture trouvée avec ce numéro de téléphone. Vérifiez votre numéro.'
    ], JSON_PRETTY_PRINT) . "\n";
}

echo "\n=== FIN DU TEST AJAX ===\n";
