<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Bouteille;
use Illuminate\Http\Request;

class AvisController extends Controller
{

    public function index($bouteilleId)
    {
        $bouteille = Bouteille::findOrFail($bouteilleId);
        $avis = Avis::with('utilisateur')->where('bouteille_id', $bouteilleId)->get();

        return response()->json($avis);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'bouteille_id' => 'required|exists:bouteilles,id',
            'commentaire' => 'nullable|string',
            'note' => 'nullable|integer|min:1|max:5',
            // add any other validation rules you want
        ]);

        $avis = Avis::create([
            'bouteille_id' => $request->bouteille_id,
            'utilisateur_id' => auth()->user()->id,
            'commentaire' => $request->commentaire,
            'note' => $request->note,
            // add any other fields you want to fill in
        ]);

        return response()->json([
            'message' => 'Avis created successfully',
            'data' => $avis,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Avis  $avis
     * @return \Illuminate\Http\Response
     */
    public function show(Avis $avis)
    {
        return response()->json([
            'data' => $avis,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Avis  $avis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Avis $avis)
    {
        $request->validate([
            'bouteille_id' => 'sometimes|required|exists:bouteilles,id',
            'utilisateur_id' => 'sometimes|required|exists:utilisateurs,id',
            'commentaire' => 'nullable|string',
            'note' => 'nullable|integer|min:1|max:5',
            // add any other validation rules you want
        ]);

        $avis->update($request->only([
            'bouteille_id',
            'utilisateur_id',
            'commentaire',
            'note',
            // add any other fields you want to update
        ]));

        return response()->json([
            'message' => 'Avis updated successfully',
            'data' => $avis,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Avis  $avis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Avis $avis)
    {
        $avis->delete();

        return response()->json([
            'message' => 'Avis deleted successfully',
        ]);
    }
}