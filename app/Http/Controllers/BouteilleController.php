<?php

namespace App\Http\Controllers;

use App\Models\Bouteille;
use App\Models\Cellier;
use App\Models\archive;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BouteilleController extends Controller
{
    /**
     * Obtenir toutes les bouteilles
     * @return \Illuminate\Http\Response
     */
    public function GetBouteilles()
    {

        try {

            // Obtenir toutes les bouteilles avec les relations pays et catégorie
            $bouteilles = Bouteille::with('categorie', 'pays')->get();

            // Retourner les bouteilles en format JSON
            return response()->json($bouteilles);
        } catch (\Exception $e) {

            // Afficher un message d'erreur personnalisé dans la console pour des raisons de débogage
            error_log($e->getMessage());

            // Retourner un message d'erreur général au client
            return response()->json([
                'message' => 'Nous nous excusons, une erreur s\'est produite sur le serveur. Veuillez réessayer plus tard.'
            ], 500);
        }
    }

    /**
     * Sauvegarder une bouteille
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */

    public function sauveBouteille(Request $request,  $cellierId)
    {
        $utilisateur = Auth::user();
        $cellier = Cellier::findOrFail($cellierId);

        // Verifier  si le cellier appartiens a l'utilisateur connecté
        if ($utilisateur->id == $cellier->utilisateur_id) {
            try {

                // Valider la requête entrante
                $validator = Validator::make($request->all(), [
                    'nom' => 'required|min:2',
                    'description'=> 'nullable|min:2',
                    'prix' => 'numeric',
                    'note' => 'numeric',
                    'nbr_notes' => 'integer',
                    'pays_id' => 'required|numeric|integer',
                    'categorie_id' => 'required|numeric|integer',
                    'quantite' => 'required|integer|min:1',
                ]);

                // Si les données ne sont pas valide, lancer une exception

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                // Si aucune photo n'a été envoyée, définir une photo par défaut
                if ($request->hasFile('photo')) {

                    $path = "storage/" . $request->file('photo')->store('photos', 'public');
                } else {
                    $path = 'https://www.saq.com/media/catalog/product/1/4/14064101-1_1578550524.png?quality=80&fit=bounds&height=166&width=111&canvas=111:166';
                }

                // Créer une nouvelle bouteille avec les données envoyées
                $bouteilleData = $request->except('quantite');

                $bouteilleData['photo'] = $path;
                $bouteille = Bouteille::create($bouteilleData);

                // Récupérer la quantité à partir de la requête
                $quantite = $request->input('quantite');

                // Attacher la bouteille au cellier avec la quantité
                $cellier->bouteilles()->attach($bouteille, ['quantite' => $quantite]);

                // Retourner une réponse
                return response()->json([
                    'status' => 'success',
                    'bouteille' => $bouteille,
                    'message' => 'Bouteille ajoutée avec succès.',
                ], 201);
            } catch (ValidationException $e) {

                // Retourner un message d'erreur personnalisé pour les erreurs de validation
                return response()->json([
                    'status' => 'échec',
                    'erreur' => 'Les données sont invalide, veuillez remplir les champs correctement.'
                ], 422);

            } catch (\Exception $e) {
                // Afficher un message d'erreur personnalisé dans la console pour des raisons de débogage
                error_log($e->getMessage());

                // Retourner un message d'erreur général au client
                return response()->json([
                    'status' => 'échec',
                    'erreur' => $e->getMessage(),
                ], 500);
            }

        }else {
            // Retourner un message d'erreur général au client
            return response()->json([
                'status' => 'échec',
                'message' => 'Vous n\'avez pas la permission d\'ajouter une bouteille à ce cellier.',
            ], 404);
        }

    }

    /**
     * Ajouter une bouteille au cellier de l'utilisateur
     *
     */
    public function ajoutBouteilleAuCellier($cellierId, $bouteilleId, $quantite)
    {
        try {
            // Obtenir le cellier de l'utilisateur
            $cellier = Cellier::where('utilisateur_id', Auth::user()->id)->findOrFail($cellierId);
            $bouteille = Bouteille::findOrFail($bouteilleId);

            // Si la quantité envoyée est inférieure à 1, le mettre  à 1 car c'est la valeur minimale
            if($quantite < 1){
                $quantite = 1;
            }

            // Vérifier si la bouteille existe déjà dans le cellier
            $bouteilleExistante = $cellier->bouteilles()->wherePivot('bouteille_id', $bouteilleId)->first();

            if ($bouteilleExistante) {
                // Si la bouteille existe déjà, ajouter la quantité envoyée en paramètres à sa quantité existante
                $quantite += $bouteilleExistante->pivot->quantite;
                $cellier->bouteilles()->updateExistingPivot($bouteilleId, ['quantite' => $quantite]);

            } else {
                //Si la bouteille n'existe pas, l'attacher au cellier avec la quantité envoyée en paramètres
                $cellier->bouteilles()->attach($bouteille, ['quantite' => $quantite]);

            }
            // Retourner une réponse
            return response()->json([
                'status' => 'success',
                'message' => 'Votre bouteille a été ajoutée au cellier avec succès!',
            ], 201);

        } catch (\Exception $e) {

            // Afficher un message d'erreur personnalisé dans la console pour des raisons de débogage
            error_log($e->getMessage());

            return response()->json([
                'status' => 'échec',
                'message' => 'Nous nous excusons, une erreur s\'est produite sur le serveur. Veuillez réessayer plus tard.'
            ], 500);
        }
    }
    /**
     * Supprimer ou enlever une bouteille dans cellier de l'utilisateur
     *
     */

     public function supprimerBouteilleDansCellier(Cellier $cellier, Bouteille $bouteille )
        {
            $utilisateur = Auth::user();

            // Vérifier si le cellier appartient à l'utilisateur connecté
            if ($utilisateur->id == $cellier->utilisateur_id) {
                try {
                    // Fetch la bouteille dans le  cellier
                    $bouteilleDansCellier = $cellier->bouteilles()
                        ->wherePivot('bouteille_id', $bouteille->id)
                        ->wherePivot('cellier_id', $cellier->id)
                        ->first();

                    if (!$bouteilleDansCellier) {
                        return response()->json([ 'status' => 'échec', 'message' => 'La bouteille n\'est pas dans le cellier.'], 404);
                    }

                    $quantite = $bouteilleDansCellier->pivot->quantite;
                    $updatedQuantity = $quantite;

                    // Si la quantité est supérieure à 1, décrémenter la quantité
                    if ($quantite > 1) {
                        $updatedQuantity = $quantite - 1;
                        $cellier->bouteilles()->updateExistingPivot($bouteille->id, ['quantite' => $updatedQuantity]);
                    } else {
                        // Si la quantité est 1, détacher la bouteille du cellier
                        $cellier->bouteilles()->detach($bouteille->id);
                        $updatedQuantity = 0;
                    }

                    return response()->json([ 'status' => 'success', 'message' => 'La bouteille a été supprimée du cellier avec succès.', 'quantite' => $updatedQuantity]);
                } catch (\Throwable $th) {
                    return response()->json([ 'status' => 'échec', 'message' => 'Une erreur est survenue lors de la suppression de la bouteille du cellier'], 500); // retourner une message d'erreur du serveur
                }
            } else {
                return response()->json([ 'status' => 'échec', 'message' => 'Vous n\'avez pas la permission de supprimer cette bouteille.'], 403); // retourner une message d'erreur de permission
            }
        }


     

    /**
     * Obtenir toutes les bouteilles d'un cellier
     */
    public function getBouteillesByCellierId(Cellier $cellier)
    {
        try {
            // Obtenir les bouteilles appartenant au cellier passé en paramètre avec les informations de la catégorie et du pays et aussi en calculant la moyenne des notes
            $bouteilles = $cellier->bouteilles()
            ->with(['categorie', 'pays', 'avis' => function($query) {
                $query->selectRaw('bouteille_id, AVG(note) as moyenneNotes')
                    ->groupBy('bouteille_id');
            }])
            ->withPivot('quantite')
            ->get();

            //  Ajouter un attribut moyenneNotes à chaque bouteille
            foreach ($bouteilles as $bouteille) {
                if(!$bouteille->avis->isEmpty()){
                    $avis = $bouteille->avis->first();
                    $bouteille->moyenneNotes = $avis->moyenneNotes;
                } else {
                    $bouteille->moyenneNotes = 0;
                }
            }

            // Renvoyer la réponse avec les bouteilles
            return response()->json([
                'status' => 'success',
                'bouteilles' => $bouteilles
            ], 200);
        } catch (\Exception $e) {
            // Afficher un message d'erreur personnalisé dans la console pour des raisons de débogage
            error_log($e->getMessage());

            return response()->json([
                'status' => 'échec',
                'erreur' => 'Nous nous excusons, une erreur s\'est produite sur le serveur. Veuillez réessayer plus tard.'
            ], 500);
        }
    }
    // Obtenir une bouteille par son id
    public function showBouteille(Bouteille $bouteille)
    {
        try {
            // Vérifier si la bouteille se trouve dans le cellier de l'utilisateur authentifié
            $bouteille = Bouteille::with('categorie', 'pays')->find($bouteille->id);

            if ($bouteille) {
                // Renvoyer la bouteille avec pays et catégorie


                return response()->json([
                    'status' => 'success',
                    'bouteille' => $bouteille
                ]);

            } else {
                return response()->json([
                    'status' => 'échec',
                    'erreur' => 'La bouteille demandée ne se trouve pas dans votre cellier.'
                ], 403);
            }
        } catch (\Exception $e) {
            // Afficher un message d'erreur personnalisé dans la console pour des raisons de débogage
            error_log($e->getMessage());

            return response()->json([
                'status' => 'échec',
                'erreur' => 'Nous nous excusons, une erreur s\'est produite sur le serveur. Veuillez réessayer plus tard.'
            ], 500);
        }
    }


    // Va mettre à jour les données d'une bouteille personnalisée
    public function updateBouteille(Bouteille $bouteille, Cellier $cellier, Request $request)
    {
        try {
            // Valider la requête entrante
            $validator = Validator::make($request->all(), [
                'nom' => 'required|min:2',
                'description'=> 'nullable|min:2',
                'prix' => 'numeric',
                'pays_id' => 'required',
                'categorie_id' => 'required',
                'quantite' => 'required|integer|min:1',
            ]);

            // Si les données ne sont pas valide, lancer une exception

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Récupérer l'ancien chemin d'image de la base de données en utilisant l'ID de l'instance $bouteille

            $ancienneImageUrl = $bouteille->photo;

            // Chemin d'image par défaut
            $defaultImagePath = 'https://www.saq.com/media/catalog/product/1/4/14064101-1_1578550524.png?quality=80&fit=bounds&height=166&width=111&canvas=111:166';

            // Vérifier si une nouvelle photo a été envoyée
            if ($request->hasFile('photo')) {
                // Supprimer l'ancien fichier image s'il ne s'agit pas de l'image par défaut
                if ($ancienneImageUrl !== $defaultImagePath) {
                    $oldImageLocalPath = str_replace("storage/", "", $ancienneImageUrl);
                    Storage::disk('public')->delete($oldImageLocalPath);
                }

                // Stocker la nouvelle photo et mettre à jour le chemin
                $path = "storage/" . $request->file('photo')->store('photos', 'public');
            } else {
                // Utiliser l'ancien chemin d'image si aucune nouvelle photo n'est envoyée
                $path = $ancienneImageUrl;
            }

            // Va mettre à jour les données des colonnes correspondantes avec celles de la requête
            $bouteille->fill($request->only($bouteille->getFillable()));

             // Récupérer la quantité à partir de la requête
             $quantite = $request->input('quantite');

            // Mettre à jour la quantité
            $cellier->bouteilles()->syncWithoutDetaching([$bouteille->id => ['quantite' => $quantite]]);

            $bouteille["photo"] = $path;

            // Sauvegarde les nouvelles informations
            $bouteille->save();

            // Retourne un message si la bouteille a été modifiée avec succès
            return response()->json([
                'message' => 'La bouteille a été modifiée avec succès'
            ]);
        } catch (\Exception $e) {
            // Afficher un message d'erreur personnalisé dans la console pour des raisons de débogage
            error_log($e->getMessage());

            // Retourner un message d'erreur général au client
            return response()->json([
                'status' => 'échec',
                'erreur' => $e->getMessage(),
            ], 500);
        }
    }



    /**
     * Supprimer une bouteille
     */
    public function destroyBouteille(Bouteille $bouteille)
    {
        $bouteille->delete();

        return response()->json([
            'message' => 'La bouteille a été supprimée avec succès.'
        ]);
    }
    /**
     * Obtenir une bouteille par son nom
     */
    public function getResultatsBouteilles($valeur)
    {
        // Va chercher la bouteille correspondant à le nom envoyé
        $bouteilles = Bouteille::where('nom', 'LIKE', '%' . $valeur . '%')
            ->whereNotNull('code_saq')
            ->with(['categorie', 'pays', 
                'avis' => function($query) {
                    $query->selectRaw('bouteille_id, AVG(note) as moyenneNotes')
                        ->groupBy('bouteille_id');
                }
            ])
            ->take(5)
            ->get();

        foreach ($bouteilles as $bouteille) {
            if(!$bouteille->avis->isEmpty()){
                $avis = $bouteille->avis->first();
                $bouteille->moyenneNotes = $avis->moyenneNotes;
            } else {
                $bouteille->moyenneNotes = 0;
            }
        }

        return response()->json($bouteilles);
    }
    public function updateQuantite($id, Request $request)
    {

        try {
            $cellierId = $request->input('cellier_id');
            $bouteilleId = $id;
            $quantite = $request->input('quantite');

            $cellier = Cellier::findOrFail($cellierId);

            $cellier->bouteilles()->updateExistingPivot($bouteilleId, ['quantite' => $quantite]);

            return response()->json(['message' => 'Quantité mise à jour avec succès']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}