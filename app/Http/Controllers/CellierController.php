<?php

namespace App\Http\Controllers;

use App\Models\Cellier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class cellierController extends Controller
{
    public function index()
    {
        $celliers = Cellier::where('utilisateur_id', Auth::user()->id)->get();

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
    public function getBouteilles()
    {
        $cellier = Cellier::where('utilisateur_id', Auth::user()->id)->firstOrFail();
        $bouteilles = $cellier->bouteilles()->with('pays', 'categorie')->get();
        return response()->json($bouteilles);
    }
    public function supprimerBouteilleCellier($id, $bouteilleId)
    {
        // Get the authenticated user's cellier
        $cellier = Cellier::where('utilisateur_id', Auth::user()->id)->firstOrFail();
    
        // Check if the bouteille exists in the cellier
        $bouteille = $cellier->bouteilles()->find($bouteilleId);
        if (!$bouteille) {
            return response()->json(['error' => 'Bouteille non trouvée dans le cellier'], 404);
        }
    
        // Remove the bouteille from the cellier
        $cellier->bouteilles()->detach($bouteilleId);
    
        return response()->json(['success' => 'Bouteille supprimée du cellier'], 200);
    }
    
}
