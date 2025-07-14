<?php

echo "=== TEST CURL DE L'APPEL AJAX ===\n\n";

// URL de base (ajustez selon votre configuration)
$baseUrl = 'http://localhost:8000';

// Données à envoyer
$data = json_encode([
    'numero_whatsapp' => '23244566'
]);

// Headers
$headers = [
    'Content-Type: application/json',
    'Accept: application/json',
    'X-Requested-With: XMLHttpRequest'
];

echo "URL: " . $baseUrl . "/client/verify-phone\n";
echo "Données: " . $data . "\n\n";

// Initialiser cURL
$ch = curl_init();

// Configuration cURL
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/client/verify-phone');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

// Exécuter la requête
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);

// Fermer cURL
curl_close($ch);

echo "Code HTTP: " . $httpCode . "\n";

if ($error) {
    echo "Erreur cURL: " . $error . "\n";
} else {
    echo "Réponse reçue:\n";
    echo $response . "\n\n";

    // Décoder la réponse JSON
    $responseData = json_decode($response, true);

    if ($responseData) {
        echo "Réponse décodée:\n";
        echo "Success: " . ($responseData['success'] ? 'true' : 'false') . "\n";
        echo "Message: " . $responseData['message'] . "\n";
    } else {
        echo "Impossible de décoder la réponse JSON\n";
    }
}

echo "\n=== FIN DU TEST CURL ===\n";
