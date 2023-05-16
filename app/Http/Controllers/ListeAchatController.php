<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bouteille;
use App\Models\ListeAchat;
use App\Models\Cellier;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ListeAchatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getListe(Utilisateur $utilisateur)
    {
        Log::info($utilisateur);
        // Verifier  si le cellier appartiens a l'utilisateur connecté
        if ($utilisateur->id == Auth::user()->id) {
            try {
                Log::info('gagagaga');

                // Récupérer les bouteilles archivées de l'utilisateur avec les information de la bouteille et de l'utilisateur
                $liste_achats = ListeAchat::with('bouteille.categorie', 'bouteille.pays', 'utilisateur')
                    ->where('utilisateur_id', $utilisateur->id)
                    ->get();


                Log::info($liste_achats);

                return response()->json(['liste' => $liste_achats, 'message' => 'Bouteille archivée avec succès']); // retourner un message de succès
            } catch (\Throwable $th) {
                return response()->json(['status' => 'échec', 'message' => 'Une erreur est survenue, veuillez réessayer plus tard'], 500); // retourner une message d'erreur du serveur
            }
        } else {
            //
            return response()->json(['message' => 'Accès non autorisé'], 404); // retourner un message d'erreur avec code 404 si l'utilisateur n'est pas propriétaire du cellier
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($listeId, $quantite, $utilisateurId)
    {
        //
        if ($utilisateurId == Auth::user()->id) {
            try {
                Log::info($quantite);
                Log::info($listeId);
                Log::info($utilisateurId);
                // Récupérer les bouteilles archivées de l'utilisateur avec les information de la bouteille et de l'utilisateur
                $liste_achat = ListeAchat::where('id', $listeId)->first();
                if($quantite > 0){
                    $liste_achat->quantite = $quantite;
                    $liste_achat->save();
                }else{
                    $liste_achat->delete();
                }
            } catch (\Throwable $th) {
                return response()->json(['status' => 'échec', 'message' => 'Une erreur est survenue, veuillez réessayer plus tard'], 500); // retourner une message d'erreur du serveur
            }
        } else {
            //
            return response()->json(['message' => 'Accès non autorisé'], 404); // retourner un message d'erreur avec code 404 si l'utilisateur n'est pas propriétaire du cellier
        }
    }
}
