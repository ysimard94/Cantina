<?php

use App\Http\Controllers\BouteilleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\SAQController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\CellierController;
use App\Http\Controllers\BouteilleCellierController;
use App\Http\Controllers\UtilisateurController;



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

Route::middleware('auth:api')->group(function () {

    // à compléter

    Route::put('/utilisateur-edit/{utilisateur}', [UtilisateurController::class, 'update']);
    Route::get('/utilisateur-show/{utilisateur}', [UtilisateurController::class, 'show']);
});
Route::get('/categorie', [CategorieController::class, 'index']);
Route::post('/ajouter-bouteille', [BouteilleController::class, 'create']);
    Route::get('/pays', [PaysController::class, 'index']);
    Route::get('/bouteilles', [BouteilleController::class, 'index']);
Route::get('/saq-produits', [SAQController::class, 'index']);

Route::post('/enregistrer', [AuthController::class, 'sauvegarder']);

Route::post('/connexion', [AuthController::class, 'authentifier']);


Route::get('/celliers/{id}/bouteilles', [cellierController::class, 'getBouteilles']);

// route pour avoir supprimer une bouteille dans cellier
Route::delete('/celliers/{cellierId}/bouteilles/{bouteilleId}', [CellierController::class, 'supprimerBouteilleCellier']);

// route pour ajouter une bouteille dans une cellier

Route::post('/celliers/{cellierId}/bouteilles/{bouteilleId}', [BouteilleCellierController::class, 'store']);
