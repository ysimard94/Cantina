<?php

namespace App\Http\Controllers;

use App\Models\Bouteille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BouteilleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //     public function index($nombre, $page)
    // {
    //     // Calculate the offset based on the number of items per page and the current page number
    //     $offset = ($page - 1) * $nombre;

    //     // Retrieve the specified number of products from the database using pagination
    //     $produits = Bouteille::offset($offset)->limit($nombre)->get();

    //     // Get the total number of products
    //     $totalProduits = Bouteille::count();

    //     return response()->json(['produits' => $produits, 'total' => $totalProduits]);
    // }

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