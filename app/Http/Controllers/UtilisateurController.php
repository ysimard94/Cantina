<?php

namespace App\Http\Controllers;

use App\Models\utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

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
    public function show(utilisateur $utilisateur)
    {
        // // Vérifier si l'utilisateur est correct

        // if ($utilisateur->id !== auth()->user()->id) {
        //     return response()->json(['code' => 'utilisateur_incorrect']);
        // }

        // // Retourner une réponse avec les données de l'utilisateur
        $utilisateur = auth()->user();
        return response()->json([
            'user' =>  $utilisateur,
        ]);
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
    public function update(Request $request, utilisateur $utilisateur)
    {
         // Valider les données
         $request->validate([
            'nom' => 'required',
            'courriel' => 'required|email',
            'mdb_courant' => 'required|min:3',
            'mdp_nouveau' => 'required|min:3'
        ]);

        // Vérifier si le mot de passe est correct
        if (!Hash::check($request->mdb_courant, $utilisateur->mdp)) {
            return response()->json(['code' => 'mot_de_passe_incorrect']);
        }

        $utilisateur->fill($request->only(['nom', 'courriel']));
        $utilisateur->mdp = Hash::make($request->mdp_nouveau);

        $utilisateur->save();

        return response()->json([
            'message' => 'Utilisateur modifié avec succès',
            'utilisateur' => $utilisateur,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(utilisateur $utilisateur)
    {
        //
    }
}
