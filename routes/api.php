<?php

use App\Http\Controllers\BouteilleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\SAQController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Products routes
Route::get('/saq-produits', [SAQController::class, 'index']);

// Categories routes
Route::get('/categorie', [CategorieController::class, 'index']);

// Authentification routes
Route::post('/enregistrer', [AuthController::class, 'sauvegarder']);