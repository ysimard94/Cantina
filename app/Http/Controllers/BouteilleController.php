<?php

namespace App\Http\Controllers;

use App\Models\Bouteille;
use App\Models\Cellier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;

class BouteilleController extends Controller
{
    public function index()
    {
        $bouteilles = Bouteille::with('categorie', 'pays')->get();
        return response()->json($bouteilles);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'categorie_id' => 'required',
            'pays_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Erreur de validation.'
            ], 400);
        }

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'local');
        } else {
            $path = 'https://www.saq.com/media/catalog/product/1/4/14064101-1_1578550524.png?quality=80&fit=bounds&height=166&width=111&canvas=111:166';
        }

        $bouteilleData = $request->all();
        $bouteilleData['photo'] = $path;
        $bouteille = Bouteille::create($bouteilleData);
        
        $cellier = Cellier::where('utilisateur_id', Auth::user()->id)->firstOrFail();
        $cellier->bouteilles()->attach($bouteille);

        return response()->json(['message' => 'Bouteille ajoutée avec succès.']);
    }

    public function ajoutAuCellier($cellierId, $bouteilleId)
    {
        $cellier = Cellier::where('utilisateur_id', Auth::user()->id)->firstOrFail();
        $bouteille = Bouteille::findOrFail($bouteilleId);

        $cellier->bouteilles()->attach($bouteille);

        return response()->json(['message' => 'Bouteille ajoutée au cellier avec succès.']);
    }

    public function show(Bouteille $bouteille)
    {
        return response()->json($bouteille);
    }
}
