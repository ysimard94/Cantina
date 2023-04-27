<?php

namespace App\Http\Controllers;

use App\Models\Cellier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
class cellierController extends Controller
{
    public function index()
    {
        $celliers = Cellier::where('utilisateur_id', Auth::user()->id)->get();

    return response()->json($celliers);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cellier = new Cellier;
        $cellier->nom = $request->nom;
        $cellier->utilisateur_id = auth()->user()->id;

        $cellier->save();

        return response()->json(['success' => 'Le cellier a été ajouté avec succès!']);


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
        $cellier->utilisateur_id =auth()->user()->id;
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