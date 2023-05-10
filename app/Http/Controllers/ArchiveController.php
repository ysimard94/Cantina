<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Bouteille;
use App\Models\Cellier;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Utilisateur $utilisateur)
    {
        Log::info($utilisateur);
        // Verifier  si le cellier appartiens a l'utilisateur connecté
        if ($utilisateur->id == Auth::user()->id) {
            try {

                // Récupérer les bouteilles archivées de l'utilisateur avec les information de la bouteille et de l'utilisateur
                $archives = Archive::with('bouteille', 'utilisateur')
                ->where('utilisateur_id', $utilisateur->id)
                ->get();

                Log::info($archives);

                return response()->json(['archives' => $archives, 'message' => 'Bouteille archivée avec succès']); // retourner un message de succès
            } catch (\Throwable $th) {
                return response()->json([ 'status' => 'échec', 'message' => 'Une erreur est survenue, veuillez réessayer plus tard'], 500); // retourner une message d'erreur du serveur
            }
        } else {
            //
            return response()->json(['message' => 'Accès non autorisé'], 404); // retourner un message d'erreur avec code 404 si l'utilisateur n'est pas propriétaire du cellier
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Cellier $cellier, Bouteille $bouteille)
    {
        $utilisateur = Auth::user();

        // Verifier  si le cellier appartiens a l'utilisateur connecté
        if ($utilisateur->id == $cellier->utilisateur_id) {
            try {

                // Ajouter la bouteille dans la table archive
                $archive = new Archive;

                $archive->bouteille_id = $bouteille->id;
                $archive->utilisateur_id = $utilisateur->id;
            
                $archive->save();

                return response()->json(['message' => 'Bouteille archivée avec succès']); // retourner un message de succès
            } catch (\Throwable $th) {
                return response()->json([ 'status' => 'échec', 'message' => 'Une erreur est survenue, veuillez réessayer plus tard'], 500); // retourner une message d'erreur du serveur
            }
        } else {
            //
            return response()->json(['message' => 'Accès non autorisé'], 404); // retourner un message d'erreur avec code 404 si l'utilisateur n'est pas propriétaire du cellier
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(archive $archive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(archive $archive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, archive $archive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(archive $archive)
    {
        //
    }
}
