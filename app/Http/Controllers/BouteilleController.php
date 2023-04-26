<?php

namespace App\Http\Controllers;

use App\Models\Bouteille;
use App\Models\Cellier;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

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
        try {

            // Valider la requête entrante
            $validator = Validator::make($request->all(), [
                'nom' => 'required',
                'categorie_id' => 'required|numeric|integer',
                'pays_id' => 'required|numeric|integer',
            ]);

            // Si les données ne sont pas valide, lancer une exception

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Si aucune photo n'a été envoyée, définir une photo par défaut
            if ($request->hasFile('photo')) {
                $path = "storage/".$request->file('photo')->store('photos', 'public');
            } else {
                $path = 'https://www.saq.com/media/catalog/product/1/4/14064101-1_1578550524.png?quality=80&fit=bounds&height=166&width=111&canvas=111:166';
            }

            // Créer une nouvelle bouteille avec les données envoyées
            $bouteilleData = $request->all();
            $bouteilleData['photo'] = $path;
            $bouteille = Bouteille::create($bouteilleData);


            // Obtenir le cellier de l'utilisateur connecté
            $cellier = Cellier::where('id', $cellierId)
            ->where('utilisateur_id', Auth::user()->id)
            ->firstOrFail();

            // Attacher la bouteille au cellier
            $cellier->bouteilles()->attach($bouteille);

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
    }

    /**
     * Ajouter une bouteille au cellier de l'utilisateur
     * 
     */
    public function ajoutBouteilleAuCellier($cellierId, $bouteilleId)
    {
        try {
            // Obtenir le cellier de l'utilisateur
            $cellier = Cellier::where('utilisateur_id', Auth::user()->id)->firstOrFail();
            $bouteille = Bouteille::findOrFail($bouteilleId);

            // Attacher la bouteille au cellier 
            $cellier->bouteilles()->attach($bouteille);

            // Renvoyer un message de succès 
            return response()->json(['message' => 'Bouteille ajoutée au cellier avec succès.']);

        } catch (\Exception $e) {
            
            // Afficher un message d'erreur personnalisé dans la console pour des raisons de débogage
            error_log($e->getMessage());

            return response()->json([
                'status' => 'échec',
                'erreur' => 'Nous nous excusons, une erreur s\'est produite sur le serveur. Veuillez réessayer plus tard.'
            ], 500);
        }
    }

    /**
     * Obtenir une bouteille par son id
     */
    public function showBouteille(Bouteille $bouteille)
    {
        
        return response()->json($bouteille);
    }
}
