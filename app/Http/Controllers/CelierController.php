<?php

namespace App\Http\Controllers;

use App\Models\Celier;
use Illuminate\Http\Request;

class CelierController extends Controller
{
    public function index()
    {
        $celiers = Celier::all();

        return response()->json($celiers);
    }

    public function store(Request $request)
    {
        $celier = Celier::create([
            'nom' => $request->input('nom'),
            'utilisateur_id' => $request->input('utilisateur_id')
        ]);

        return response()->json($celier);
    }


    public function show($id)
    {
        $celier = Celier::findOrFail($id);

        return response()->json($celier);
    }

    public function update(Request $request, $id)
    {
        $celier = Celier::findOrFail($id);

        $celier->nom = $request->input('nom');
        $celier->utilisateur_id = $request->input('utilisateur_id');
        $celier->save();

        return response()->json($celier);
    }

    public function destroy($id)
    {
        $celier = Celier::findOrFail($id);

        $celier->delete();

        return response()->json(['message' => 'Celier deleted successfully']);
    }
    public function getBouteilles($id)
    {
        $cellier = Celier::find($id);
        $bouteilles = $cellier->bouteilles()->with('pays', 'categorie')->get();;
        return response()->json($bouteilles);
    }
    public function supprimerBouteilleCellier($cellierId, $bouteilleId)
    {
        // Vérifie si le cellier existe
        $cellier = Celier::find($cellierId);
        if (!$cellier) {
            return response()->json(['error' => 'Cellier non trouvé'], 404);
        }

        // Vérifie si la bouteille existe dans le cellier
        $bouteille = $cellier->bouteilles()->find($bouteilleId);
        if (!$bouteille) {
            return response()->json(['error' => 'Bouteille non trouvée dans le cellier'], 404);
        }

        // Supprime la bouteille du cellier
        $cellier->bouteilles()->detach($bouteilleId);

        return response()->json(['success' => 'Bouteille supprimée du cellier'], 200);
    }
}
