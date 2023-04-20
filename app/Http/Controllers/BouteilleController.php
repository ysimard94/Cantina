<?php

namespace App\Http\Controllers;

use App\Models\Bouteille;
use App\Models\Cellier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BouteilleController extends Controller
{


    public function index()
    {
        $bouteilles = Bouteille::with('categorie', 'pays')->get();
        return response()->json($bouteilles);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    
        // Valider la bouteille

        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'categorie_id' => 'required',
            'pays_id' => 'required',
        ]); 

        // Vérifier si une photo a été envoyée, sinon utiliser une photo personnalisée
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'local');
        } else {
            $path = 'https://www.saq.com/media/catalog/product/1/4/14064101-1_1578550524.png?quality=80&fit=bounds&height=166&width=111&canvas=111:166';
        }

        // Créer une bouteille
        $bouteilleData = $request->all();
        $bouteilleData['photo'] = $path;
        $bouteille = Bouteille::create($bouteilleData);

        return response()->json(['message' => 'Bouteille ajoutée avec succès.']);
    }
    public function ajoutAuCellier($cellierId, $bouteilleId)
    {
        $cellier = Cellier::findOrFail($cellierId);
        $bouteille = Bouteille::findOrFail($bouteilleId);

        $cellier->bouteilles()->attach($bouteille);

        return response()->json(['message' => 'Bouteille ajoutée au cellier avec succès.']);
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
    public function show(Bouteille $bouteille)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bouteille $bouteille)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bouteille $bouteille)
    {
       //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bouteille $bouteille)
    {
       //
    }


}
