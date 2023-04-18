<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
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
     * Enregistre un nouvel utilisateur
     */
    public function sauvegarder(Request $request)
    {
        // Changer le nom de la variable de confirmation de mot de passe
        $request->merge(['mdp_confirmation' => $request->get('conf_mdp')]);

        // Valider les données
        $request->validate([
            'nom' => 'required',
            'courriel' => 'required|email',
            'mdp' => 'required|min:3',
            'mdp_confirmation' => 'required|same:mdp'
        ]);

        // Créer l'utilisateur
        $utilisateur = new Utilisateur;

        // Sauvegarder les données
        $utilisateur->fill($request->all());
        $utilisateur->mdp = Hash::make($request->mdp);
        $utilisateur->save();

        // Retourner une réponse
        return response()->json(['message' => "L'Utilisateur a été créé avec succes"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Utilisateur $utilisateur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Utilisateur $utilisateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Utilisateur $utilisateur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Utilisateur $utilisateur)
    {
        //
    }
}
