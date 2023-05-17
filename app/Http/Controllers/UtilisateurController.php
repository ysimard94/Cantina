<?php

namespace App\Http\Controllers;

use App\Models\utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Utilisateur $utilisateur)
    {
        $authUtilisateur = auth()->user(); //   Récupérer l'utilisateur connecté 
        if ($authUtilisateur->id === $utilisateur->id) {
            return response()->json([
                'user' =>  $utilisateur,
            ]);
        }else {
            //  Renvoyer une erreur 403 si l'utilisateur n'est pas celui connecté
            return response()->json(['erreur' => 'Action non autorisée!'], 403);
        }

     
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(utilisateur $utilisateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Utilisateur $utilisateur)
    {
       $authUtilisateur = auth()->user(); //   Récupérer l'utilisateur connecté 
        if ($authUtilisateur->id === $utilisateur->id) {
            // Valider les données
           $request->validate([
               'nom' => 'required',
               'courriel' => 'required|email',
               'mdp_courant' => 'string|required|min:3',
               'mdp_nouveau' => 'nullable|string|min:3'
           ]);
           try {
                // Vérifier si le nouveau courriel envoyé n'existe pas dans la table Utilisateurs
                $utilisateurExiste = utilisateur::where('courriel', $request->courriel)->first();
                if ($utilisateurExiste && $utilisateurExiste->id !== $utilisateur->id) {
                    return response()->json(['erreur' => 'Le nouveau courriel existe déjà']);
                }
                  
                // Vérifier si le mot de passe est correct
                if (!Hash::check($request->mdp_courant, $utilisateur->mdp)) {

                    return response()->json(['erreur' => 'Le mot de passe est incorrect']);
                }

                $utilisateur->fill($request->only(['nom', 'courriel']));
                
                // Si en plus le nouveau mot de passe est envoyé, le mettre à jour
                if ($request->mdp_nouveau) {
                    $utilisateur->mdp = Hash::make($request->mdp_nouveau);
                }
                $utilisateur->save();
                //  Si l'opération est réussie renvoyer un message de succès
                return response()->json([
                    'message' => 'Votre profile a été mis à jour avec succès',
                    'utilisateur' => $utilisateur,
                ]);
           } catch (\Throwable $th) {
            // Si y'a une erreur serveur renvoyer un message  d'erreur 500 
            return response()->json(['erreur' => 'Une erreur s\'est produite, Veuillez réessayer plus tard'], 500);
           }
        }else {
            //  Renvoyer une erreur 403 si l'utilisateur n'est pas celui connecté
            return response()->json(['erreur' => 'Action non autorisée!'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(utilisateur $utilisateur)
    {
        //
    }
}
