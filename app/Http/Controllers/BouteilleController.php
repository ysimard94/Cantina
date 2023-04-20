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

        return response()->json($request->all());
        // Valider la bouteille
        // $request->validate([
        //     'nom' => 'required',
        //     'photo' => 'file|image|max:2048',
        //     'categorie_id' => 'required',
        //     'pays_id' => 'required',
        // ]);

        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'photo' => 'file|image|max:2048',
            'categorie_id' => 'required',
            'pays_id' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

      

        // Vérifier si une photo a été envoyée, sinon utiliser une photo personnalisée
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'local');
        } else {
            $path = 'ressources/assets/bouteille.webp';
        }

        // Créer une bouteille
        $bouteilleData = $request->all();
        $bouteilleData['photo'] = $path;
        $bouteille = Bouteille::create($bouteilleData);

        return response()->json($bouteille, 201);
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
