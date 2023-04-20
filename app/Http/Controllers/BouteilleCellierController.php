<?php

namespace App\Http\Controllers;

use App\Models\BouteilleCellier;
use App\Models\Bouteille;
use App\Models\Cellier;
use Illuminate\Http\Request;

class BouteilleCellierController extends Controller
{
    public function index()
    {
        $bouteillecelliers = BouteilleCellier::all();

        return response()->json($bouteillecelliers);
    }

    public function store($cellierId, $bouteilleId)
    {
        $cellier = Cellier::findOrFail($cellierId);
        $bouteille = Bouteille::findOrFail($bouteilleId);

        $cellier->bouteilles()->attach($bouteille);

        return response()->json(['message' => 'Bouteille ajoutée au cellier avec succès.']);
    }

    public function show($id)
    {
        $bouteillecellier = BouteilleCellier::findOrFail($id);

        return response()->json($bouteillecellier);
    }

    public function update(Request $request, $id)
    {
        $bouteillecellier = BouteilleCellier::findOrFail($id);

        $bouteillecellier->update([
            'cellier_id' => $request->input('cellier_id'),
            'bouteille_id' => $request->input('bouteille_id')
        ]);
    }
}
