<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListeAchat;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Auth;

class ListeAchatController extends Controller
{
    // Retourne les bouteilles de la liste d'achats de l'utilisateur
    public function getListe(Utilisateur $utilisateur)
    {
        // Verifier  si le le id d'utilisateur envoyé est le même que celui connecté
        if ($utilisateur->id == Auth::user()->id) {
            try {
                // Récupérer les bouteilles archivées de l'utilisateur avec les information de la bouteille et de l'utilisateur
                $liste_achats = ListeAchat::with('bouteille.categorie', 'bouteille.pays', 'utilisateur')
                    ->where('utilisateur_id', $utilisateur->id)
                    ->get();

                return response()->json(['liste' => $liste_achats]);
            } catch (\Throwable $th) {
                return response()->json(['status' => 'échec', 'message' => 'Une erreur est survenue, veuillez réessayer plus tard'], 500); // retourner une message d'erreur du serveur
            }
        } else {
            //
            return response()->json(['message' => 'Accès non autorisé'], 404); // Retourner un message d'erreur avec code 404 si l'id envoyé n'est pas celui de l'utilisateur
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    // Ajoute une bouteille à la liste d'achats de l'utilisateur
    public function ajouterBouteilleALaListe($utilisateurId, $bouteilleId)
    {
        // Verifier  si le le id d'utilisateur envoyé est le même que celui connecté
        if ($utilisateurId == Auth::user()->id) {
            try {
                // Récupérer les bouteilles archivées de l'utilisateur avec les information de la bouteille et de l'utilisateur
                $listeAchat = ListeAchat::where('utilisateur_id', $utilisateurId)
                    ->where('bouteille_id', $bouteilleId)
                    ->first();

                if ($listeAchat) {
                    // Si la bouteille est déjà dans la liste d'achats, ajouter 1 à la quantité
                    $listeAchat->increment('quantite');
                } else {
                    // Sinon, l'insérer dans la liste
                    ListeAchat::create([
                        'utilisateur_id' => $utilisateurId,
                        'bouteille_id' => $bouteilleId,
                        'quantite' => 1,
                    ]);
                }

                return response()->json(['message' => 'Bouteille ajoutée dans votre liste d\'achats avec succès']); // retourner un message de succès
            } catch (\Throwable $th) {
                return response()->json(['status' => 'échec', 'message' => 'Une erreur est survenue, veuillez réessayer plus tard'], 500); // retourner une message d'erreur du serveur
            }
        } else {
            //
            return response()->json(['message' => 'Accès non autorisé'], 404); // Retourner un message d'erreur avec code 404 si l'id envoyé n'est pas celui de l'utilisateur
        }
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

    // Supprime la bouteille de la liste d'achats
    public function destroy($listeId, $quantite, $utilisateurId)
    {
        //
        if ($utilisateurId == Auth::user()->id) {
            try {
                // Récupérer les bouteilles archivées de l'utilisateur avec les information de la bouteille et de l'utilisateur
                $liste_achat = ListeAchat::where('id', $listeId)->first();
                if ($quantite > 0) {
                    $liste_achat->quantite = $quantite;
                    $liste_achat->save();
                } else {
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
