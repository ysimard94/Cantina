<?php

namespace App\Http\Controllers;

use App\Models\Bouteille;
use Illuminate\Http\Request;

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
        $bouteilles = Bouteille::all();
        return response()->json($bouteilles);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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