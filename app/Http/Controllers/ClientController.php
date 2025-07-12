<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class ClientController extends Controller
{
    /**
     * Afficher la page de connexion client
     */
    public function showLogin(): View
    {
        return view('client.login');
    }

    /**
     * Traiter la connexion client
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'numero_whatsapp' => 'required|string|min:8',
        ]);

        // Nettoyer le numéro de téléphone
        $numero = preg_replace('/[^0-9]/', '', $request->numero_whatsapp);

        // Chercher les commandes avec ce numéro
        $commandes = Commande::where('numero_whatsapp', 'LIKE', '%' . $numero . '%')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($commandes->isEmpty()) {
            return back()->withErrors([
                'numero_whatsapp' => 'Aucune facture trouvée avec ce numéro de téléphone. Vérifiez votre numéro.'
            ]);
        }

        // Récupérer le nom du client depuis la première commande
        $clientNom = $commandes->first()->client;

        // Stocker les informations en session
        Session::put('client_info', [
            'nom' => $clientNom,
            'numero_whatsapp' => $request->numero_whatsapp,
            'commandes_count' => $commandes->count()
        ]);

        return redirect()->route('client.factures');
    }

    /**
     * Afficher les factures du client
     */
    public function showFactures()
    {
        $clientInfo = Session::get('client_info');

        if (!$clientInfo) {
            return redirect()->route('client.login');
        }

        // Nettoyer le numéro de téléphone
        $numero = preg_replace('/[^0-9]/', '', $clientInfo['numero_whatsapp']);

        // Récupérer toutes les commandes du client
        $commandes = Commande::where('numero_whatsapp', 'LIKE', '%' . $numero . '%')
            ->with(['objets', 'payments'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculer les statistiques
        $totalCommandes = $commandes->count();
        $totalMontant = $commandes->sum('total');
        $commandesEnCours = $commandes->whereIn('statut', ['Non retirée', 'Partiellement payé'])->count();
        $commandesTerminees = $commandes->where('statut', 'Retiré')->count();

        return view('client.factures', compact(
            'commandes',
            'clientInfo',
            'totalCommandes',
            'totalMontant',
            'commandesEnCours',
            'commandesTerminees'
        ));
    }

    /**
     * Déconnexion client
     */
    public function logout(): RedirectResponse
    {
        Session::forget('client_info');
        return redirect()->route('client.login')->with('success', 'Vous avez été déconnecté avec succès.');
    }

    /**
     * Télécharger une facture spécifique
     */
    public function downloadFacture($id)
    {
        $clientInfo = Session::get('client_info');

        if (!$clientInfo) {
            return redirect()->route('client.login');
        }

        $commande = Commande::with(['objets', 'payments', 'user'])
            ->findOrFail($id);

        // Vérifier que la commande appartient bien au client
        $numero = preg_replace('/[^0-9]/', '', $clientInfo['numero_whatsapp']);
        if (!str_contains($commande->numero_whatsapp, $numero)) {
            return redirect()->route('client.factures')->with('error', 'Accès non autorisé.');
        }

        // Générer le PDF de la facture
        $pdf = Pdf::loadView('factures.template', compact('commande'));

        return $pdf->download('facture-' . $commande->numero . '.pdf');
    }
}
