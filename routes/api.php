<?php

use App\Http\Controllers\BouteilleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\SAQController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaysController;



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
    Route::get('/categorie', [CategorieController::class, 'index']);
Route::get('/pays', [PaysController::class, 'index']);
Route::get('/bouteilles', [BouteilleController::class, 'index']);
Route::put('/utilisateur-edit/{utilisateur}', [UtilisateurController::class, 'update']);
Route::put('/utilisateur-show/{utilisateur}', [UtilisateurController::class, 'show']);
});

Route::get('/saq-produits', [SAQController::class, 'index']);

Route::post('/enregistrer', [AuthController::class, 'sauvegarder']);

Route::post('/connexion', [AuthController::class, 'authentifier']);