<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

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
     * Vérifier le numéro de téléphone via AJAX
     */
    public function verifyPhone(Request $request): JsonResponse
    {
        $request->validate([
            'numero_whatsapp' => 'required|string|min:8',
        ]);

        // Nettoyer le numéro de téléphone
        $numero = preg_replace('/[^0-9]/', '', $request->numero_whatsapp);

        // Chercher les commandes avec ce numéro
        $commandes = Commande::where('numero_whatsapp', 'LIKE', '%' . $numero . '%')
            ->whereNotNull('password_client')
            ->first();

        if (!$commandes) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune facture trouvée avec ce numéro de téléphone. Vérifiez votre numéro.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Numéro vérifié avec succès.'
        ]);
    }

    /**
     * Vérification du numéro en PHP pur (étape 1)
     */
    public function verifyPhonePhp(Request $request)
    {
        $request->validate([
            'numero_whatsapp' => 'required|string|min:8',
        ]);

        // Nettoyer le numéro saisi
        $numero = preg_replace('/[^0-9]/', '', $request->numero_whatsapp);

        // Si le numéro fait plus de 8 chiffres, prendre les 8 derniers
        if (strlen($numero) > 8) {
            $numero = substr($numero, -8);
        }

        // D'abord, chercher le numéro (avec ou sans mot de passe)
        $commande = Commande::where(function($query) use ($numero) {
            $query->where('numero_whatsapp', 'LIKE', '%' . $numero . '%')
                  ->orWhere('numero_whatsapp', 'LIKE', '%' . substr($numero, -7) . '%')
                  ->orWhere('numero_whatsapp', 'LIKE', '%' . substr($numero, -6) . '%');
        })
        ->first();

        // Si le numéro n'existe pas du tout
        if (!$commande) {
            return redirect()->back()
                ->withErrors(['numero_whatsapp' => 'Aucune facture trouvée avec ce numéro de téléphone. Vérifiez votre numéro.'])
                ->withInput();
        }

        // Si le numéro existe mais n'a pas de mot de passe
        if (is_null($commande->password_client)) {
            return redirect()->back()
                ->withErrors(['numero_whatsapp' => 'Ce numéro de téléphone est associé à des factures, mais aucun mot de passe n\'a encore été défini. Veuillez vous rapprocher de Cica pour demander votre mot de passe.'])
                ->withInput();
        }

        // Le numéro existe et a un mot de passe, passer à l'étape 2
        return redirect()->route('client.login')
            ->with(['step' => 2, 'numero_ok' => true, 'numero_valide' => $request->numero_whatsapp]);
    }

    /**
     * Traiter la connexion client
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'numero_whatsapp' => 'required|string|min:8',
            'password_client' => 'required|string|min:1',
        ]);

        // Nettoyer le numéro saisi
        $numero = preg_replace('/[^0-9]/', '', $request->numero_whatsapp);

        // Si le numéro fait plus de 8 chiffres, prendre les 8 derniers
        if (strlen($numero) > 8) {
            $numero = substr($numero, -8);
        }

        // Chercher le numéro (avec ou sans mot de passe)
        $commande = Commande::where(function($query) use ($numero) {
            $query->where('numero_whatsapp', 'LIKE', '%' . $numero . '%')
                  ->orWhere('numero_whatsapp', 'LIKE', '%' . substr($numero, -7) . '%')
                  ->orWhere('numero_whatsapp', 'LIKE', '%' . substr($numero, -6) . '%');
        })
        ->whereNotNull('password_client')
        ->orderBy('created_at', 'desc')
        ->first();

        if (!$commande || !Hash::check($request->password_client, $commande->password_client)) {
            return back()->withErrors([
                'password_client' => 'Mot de passe incorrect ou numéro de téléphone invalide.'
            ])->withInput(['numero_whatsapp' => $request->numero_whatsapp]);
        }

        // Récupérer le nom du client depuis la commande
        $clientNom = $commande->client;

        // Stocker les informations en session
        Session::put('client_info', [
            'nom' => $clientNom,
            'numero_whatsapp' => $request->numero_whatsapp,
            'commandes_count' => 1
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
