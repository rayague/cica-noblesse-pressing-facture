<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture {{ $commande->numero }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 20px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #3b82f6;
            margin-bottom: 5px;
        }
        .company-subtitle {
            font-size: 14px;
            color: #666;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .client-info, .invoice-details {
            flex: 1;
        }
        .invoice-details {
            text-align: right;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #3b82f6;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .items-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-row {
            margin-bottom: 10px;
        }
        .total-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .total-value {
            display: inline-block;
            width: 100px;
            text-align: right;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Cica Noblesse Pressing</div>
        <div class="company-subtitle">Votre pressing de confiance</div>
    </div>

    <div class="invoice-info">
        <div class="client-info">
            <div class="section-title">Client</div>
            <div><strong>Nom:</strong> {{ $commande->client }}</div>
            <div><strong>Téléphone:</strong> {{ $commande->numero_whatsapp }}</div>
            <div><strong>Date de dépôt:</strong> {{ \Carbon\Carbon::parse($commande->date_depot)->format('d/m/Y') }}</div>
            <div><strong>Date de retrait:</strong> {{ \Carbon\Carbon::parse($commande->date_retrait)->format('d/m/Y') }}</div>
        </div>
        <div class="invoice-details">
            <div class="section-title">Facture</div>
            <div><strong>N° Commande:</strong> {{ $commande->numero }}</div>
            <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($commande->created_at)->format('d/m/Y') }}</div>
            <div><strong>Statut:</strong> {{ $commande->statut }}</div>
        </div>
    </div>

    <div class="section-title">Détails de la commande</div>
    <table class="items-table">
        <thead>
            <tr>
                <th>Service</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->objets as $objet)
                <tr>
                    <td>{{ $objet->nom }}</td>
                    <td>{{ $objet->pivot->quantite }}</td>
                    <td>{{ number_format($objet->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($objet->prix_unitaire * $objet->pivot->quantite, 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span class="total-label">Sous-total:</span>
            <span class="total-value">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</span>
        </div>
        @if($commande->avance_client > 0)
            <div class="total-row">
                <span class="total-label">Acompte payé:</span>
                <span class="total-value">-{{ number_format($commande->avance_client, 0, ',', ' ') }} FCFA</span>
            </div>
        @endif
        <div class="total-row" style="font-size: 18px; font-weight: bold; border-top: 2px solid #3b82f6; padding-top: 10px;">
            <span class="total-label">Reste à payer:</span>
            <span class="total-value">{{ number_format($commande->solde_restant, 0, ',', ' ') }} FCFA</span>
        </div>
    </div>

    <div class="footer">
        <p>Merci de votre confiance !</p>
        <p>Cica Noblesse Pressing - Téléphone: {{ $commande->numero_whatsapp }}</p>
        <p>© 2025 Cica Noblesse Pressing. Tous droits réservés.</p>
    </div>
</body>
</html>
