<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Models\Cellier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    /**
     * Enregistre un nouvel utilisateur
     */
    public function sauvegarder(Request $request)
    {
        try {
            // Créer un validateur pour les données
            $validateur = Validator::make($request->all(), [
                'nom' => 'required',
                'courriel' => 'required|email|unique:utilisateurs,courriel',
                'mdp' => 'required|min:3',
                'mdp_confirmation' => 'required|same:mdp',
            ]);

            // Valider les données reçues avec le validateur
            $validateur->validate();

            // Créer un nouveau utilisateur
            $utilisateur = new Utilisateur;

            // Sauvegarder les données
            $utilisateur->fill($request->all());
            $utilisateur->mdp = Hash::make($request->mdp);
            $utilisateur->save();

            // Créer un nouveau cellier pour l'utilisateur
            $cellier = new Cellier;
            $cellier->nom = "Cellier de " . $utilisateur->nom;
            $cellier->utilisateur_id = $utilisateur->id;
            $cellier->save();

            // Générer un token
            $token = JWTAuth::fromUser($utilisateur);

            // Retourner une réponse avec le token
            return response()->json([
                'status' => 'success',
                'message' => 'Le compte a été créé avec succès.',
                'user' => $utilisateur,
                'token' => $token,
            ], 201);
        } catch (ValidationException $e) {
            $erreurs = $e->validator->errors();
            if ($erreurs->has('courriel')) {
                return response()->json(['erreur' => 'Un utilisateur avec cette adresse e-mail existe déjà.'], 422);
            } else {
                return response()->json(['erreur' => 'Les données sont invalide, veuillez remplir les champs correctement'], 422);
            }
        } catch (\Exception $e) {
            // Afficher un message d'erreur personnalisé dans la console pour des raisons de débogage
            error_log($e->getMessage());

            // Retourner un message d'erreur général au client
            return response()->json(['erreur' => 'Nous nous excusons, une erreur s\'est produite sur le serveur. Veuillez réessayer plus tard.'], 500);
        }
    }

    /**
     * Connecte un utilisateur
     * 
     */
    public function authentifier(Request $request)
    {
        try {
            // Valider les données
            $validateur = Validator::make($request->all(), [
                'courriel' => 'required|email',
                'mdp' => 'required|min:3'
            ]);

            // Valider les données reçues avec le validateur
            $validateur->validate();

            // Chercher l'utilisateur
            $utilisateur = Utilisateur::where('courriel', $request->courriel)->first();

            // Vérifier si l'utilisateur existe
            if (!$utilisateur) {
                throw new \Exception('Adresse e-mail non trouvée.');
            }
            // Vérifier si le mot de passe est correct
            if (!Hash::check($request->mdp, $utilisateur->mdp)) {
                throw new \Exception('Mot de passe incorrect.');
            }
            $token = JWTAuth::fromUser($utilisateur);

            // Retourner une réponse
            return response()->json([
                'status' => 'success',
                'utilisateur' => $utilisateur,
                'token' => $token,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['erreur' => 'Les données sont invalide, veuillez remplir les champs correctement'], 422);
        } catch (\Exception $e) {
            // Afficher un message d'erreur personnalisé dans la console pour des raisons de débogage
            error_log($e->getMessage());

            // Retourner un message d'erreur général au client
            return response()->json(['erreur' => $e->getMessage()], 422);
        }
    }


    /**
     * Déconnecter l'utilisateur et renvoyer une réponse 
     */
    public function deconnecter(Request $request)
    {
        try {
            // Retourner une réponse
            return response()->json([
                'message' => 'Déconnecté avec succès',
            ], 200);
        } catch (\Exception $e) {
            // Afficher un message d'erreur personnalisé dans la console pour des raisons de débogage
            error_log($e->getMessage());

            // Retourner un message d'erreur général au client
            return response()->json(['erreur' => 'Nous nous excusons, une erreur s\'est produite sur le serveur lors de la déconnexion. Veuillez réessayer plus tard.'], 500);
        }
    }
}
