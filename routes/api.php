<?php

use App\Http\Controllers\BouteilleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\SAQController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\BouteilleCelierController;
use App\Http\Controllers\CelierController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Auth middleware fourni par Laravel
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Auth middleware personnalisé
Route::middleware(['Auth'])->group(function () {
    // Products routes
    Route::get('/saq-produits', [SAQController::class, 'index']);

    // Accueil routes
    // Route::get('/accueil', [AccueilController::class, 'index']);

    // Categories routes
    Route::get('/categorie', [CategorieController::class, 'index']);
    Route::get('/pays', [PaysController::class, 'index']);

    Route::get('/deconnexion', [AuthController::class, 'deconnecter']);

    // Catalogue routes

});
Route::get('/bouteilles', [BouteilleController::class, 'index']);
// Authentification routes
Route::post('/enregistrer', [AuthController::class, 'sauvegarder']);
Route::post('/connexion', [AuthController::class, 'authentifier']);

//route celiers

// Route::get('/celiers', [CelierController::class, 'index']);
// Route::post('/celiers', [CelierController::class, 'store']);
// Route::get('/celiers/{id}', [CelierController::class, 'show']);
// Route::put('/celiers/{id}', [CelierController::class, 'update']);
// Route::delete('/celiers/{id}', [CelierController::class, 'destroy']);

// route pour avoir les bouteilles au cellier
Route::get('/celliers/{id}/bouteilles', [CelierController::class, 'getBouteilles']);

// route pour avoir supprimer une bouteille dans cellier
Route::delete('/celliers/{cellierId}/bouteilles/{bouteilleId}', [CelierController::class, 'supprimerBouteilleCellier']);

// route pour ajouter une bouteille dans une cellier

Route::post('/celliers/{cellierId}/bouteilles/{bouteilleId}', [BouteilleCelierController::class, 'store']);