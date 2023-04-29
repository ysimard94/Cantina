<?php

use App\Http\Controllers\BouteilleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\SAQController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\CellierController;

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

    Route::put('/utilisateur-edit/{utilisateur}', [UtilisateurController::class, 'update']);
    Route::get('/utilisateur-show/{utilisateur}', [UtilisateurController::class, 'show']);

    Route::get('/celliers/{id}/bouteilles', [CellierController::class, 'getBouteilles']);
    Route::get('/celliers',  [CellierController::class, 'index']);
    Route::post('/celliers', [CellierController::class, 'store']);
    Route::get('/celliers/{id}', [CellierController::class, 'show']);
    Route::put('/celliers/{id}', [CellierController::class, 'update']);
    Route::delete('/celliers/{id}', [CellierController::class, 'destroy']);

    // route pour avoir supprimer une bouteille dans cellier
    Route::delete('/celliers/{cellierId}/bouteilles/{bouteilleId}', [CellierController::class, 'supprimerBouteilleCellier']);

    // Obtenir les bouteilles d'un cellier
    Route::get('/bouteilles/cellier/{cellier}', [BouteilleController::class, 'getBouteillesByCellierId']);

    // Bouteilles
    Route::post('/bouteille/{cellierId}', [BouteilleController::class, 'sauveBouteille']); // Sauvegarder une bouteille

    Route::get('/bouteilles', [BouteilleController::class, 'getBouteilles']); // Obtenir toutes les bouteilles
    Route::put('/bouteille/{bouteille}', [BouteilleController::class, 'updateBouteille']); // Modifier une bouteille
    Route::post('/celliers/{cellierId}/bouteilles/{bouteilleId}', [BouteilleController::class, 'ajoutBouteilleAuCellier']); // Ajouter une bouteille à un cellier
    
    // Résultats de recherche
    Route::get('/resultats/{valeur}', [BouteilleController::class, 'getResultatsBouteilles']); // Obtenir une bouteille
    // Pays
    Route::get('/pays', [PaysController::class, 'index']); // Obtenir tous les pays
    // Categories
    Route::get('/categorie', [CategorieController::class, 'index']); // Obtenir toutes les catégories
});


Route::get('/saq-produits', [SAQController::class, 'index']);
Route::get('/saq-produits/{bouteille}', [SAQController::class, 'getBouteilles']);

Route::post('/enregistrer', [AuthController::class, 'sauvegarder']);

Route::post('/connexion', [AuthController::class, 'authentifier']);