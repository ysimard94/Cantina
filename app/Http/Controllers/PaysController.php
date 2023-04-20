<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use Illuminate\Http\Request;

class paysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pays = Pays::orderBy('nom', 'asc')->get();
        return response()->json($pays);
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
    public function show(pays $pays)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pays $pays)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pays $pays)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pays $pays)
    {
        //
    }
}