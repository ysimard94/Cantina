<?php

namespace App\Http\Controllers;

use App\Models\BouteilleCelier;
use App\Models\Bouteille;
use App\Models\Celier;
use Illuminate\Http\Request;

class BouteilleCelierController extends Controller
{
    public function index()
    {
        $bouteilleCeliers = BouteilleCelier::all();

        return response()->json($bouteilleCeliers);
    }

    public function store($cellierId, $bouteilleId)
    {
        $cellier = Celier::findOrFail($cellierId);
        $bouteille = Bouteille::findOrFail($bouteilleId);

        $cellier->bouteilles()->attach($bouteille);

        return response()->json(['message' => 'Bouteille ajoutée au cellier avec succès.']);
    }

    public function show($id)
    {
        $bouteilleCelier = BouteilleCelier::findOrFail($id);

        return response()->json($bouteilleCelier);
    }

    public function update(Request $request, $id)
    {
        $bouteilleCelier = BouteilleCelier::findOrFail($id);

        $bouteilleCelier->update([
            'celier_id' => $request->input('celier_id'),
            'bouteille_id' => $request->input('bouteille_id')
        ]);
    }
}
