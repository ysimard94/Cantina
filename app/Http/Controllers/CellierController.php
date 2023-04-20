<?php

namespace App\Http\Controllers;

use App\Models\Cellier;
use Illuminate\Http\Request;

class cellierController extends Controller
{
    public function index()
    {
        $celliers = Cellier::all();

        return response()->json($celliers);
    }

    public function store(Request $request)
    {
        $cellier = Cellier::create([
            'nom' => $request->input('nom'),
            'utilisateur_id' => $request->input('utilisateur_id')
        ]);

        return response()->json($cellier);
    }


    public function show($id)
    {
        $cellier = Cellier::findOrFail($id);

        return response()->json($cellier);
    }

    public function update(Request $request, $id)
    {
        $cellier = Cellier::findOrFail($id);

        $cellier->nom = $request->input('nom');
        $cellier->utilisateur_id = $request->input('utilisateur_id');
        $cellier->save();

        return response()->json($cellier);
    }

    public function destroy($id)
    {
        $cellier = Cellier::findOrFail($id);

        $cellier->delete();

        return response()->json(['message' => 'cellier deleted successfully']);
    }
    public function getBouteilles($id)
    {
        $cellier = Cellier::find($id);
        $bouteilles = $cellier->bouteilles()->with('pays', 'categorie')->get();;
        return response()->json($bouteilles);
    }
    public function supprimerBouteilleCellier($cellierId, $bouteilleId)
    {
        // Vérifie si le cellier existe
        $cellier = Cellier::find($cellierId);
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
