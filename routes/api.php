<?php

use App\Http\Controllers\BouteilleController;
use App\Http\Controllers\ArchiveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\SAQController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\CellierController;
use App\Http\Controllers\ListeAchatController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\AvisController;



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
    Route::get('/celliers/{cellier}/{bouteille}', [CellierController::class, 'getCellierBouteillePivot']); // Obtenir une bouteille attachée à un cellier
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
    Route::get('/bouteille/{bouteille}', [BouteilleController::class, 'showBouteille']); // Obtenir une bouteille par son id
    Route::put('/bouteille/{bouteille}/{cellier}', [BouteilleController::class, 'updateBouteille']); // Modifier une bouteille
    Route::delete('/bouteille/{bouteille}', [BouteilleController::class, 'destroyBouteille']); // Supprimer une bouteille
    Route::post('/celliers/{cellierId}/bouteilles/{bouteilleId}+{quantite}', [BouteilleController::class, 'ajoutBouteilleAuCellier']); // Ajouter une bouteille à un cellier
    Route::post('/celliers/{cellier}/{bouteille}', [BouteilleController::class, 'supprimerBouteilleDansCellier']); // Supprimer une bouteille dans un cellier
    Route::put('/bouteille_cellier/{id}', [BouteilleController::class, 'updateQuantite']);

    // Archives
    Route::post('/archives/{cellier}/{bouteille}', [ArchiveController::class, 'store']); // Archiver une bouteille
    Route::get('/archives/{utilisateur}', [ArchiveController::class, 'index']); // Obtenir les archives d'un utilisateur

    // Liste d'achats
    Route::get('/liste-achats/{utilisateur}', [ListeAchatController::class, 'getListe']); // Obtenir la liste d'achats d'un utilisateur
    Route::post('/liste-achats/{utilisateurId}+{bouteilleId}', [ListeAchatController::class, 'ajouterBouteilleALaListe']); // Ajouter une bouteille à la liste d'achats
    Route::delete('/liste-achats/{listeId}+{quantite}+{utilisateurId}', [ListeAchatController::class, 'destroy']); // Ajouter une bouteille à la liste d'achats

    //Avis
    Route::get('/avis/{bouteilleId}', [AvisController::class, 'index']); // afficher les avis pour chaque bouteille
    Route::post('/avis', [AvisController::class, 'store']);
    // Résultats de recherche

    Route::get('/resultats/{valeur}', [BouteilleController::class, 'getResultatsBouteilles']); // Obtenir une bouteille
    // Pays
    Route::get('/pays', [PaysController::class, 'index']); // Obtenir tous les pays
    // Categories
    Route::get('/categorie', [CategorieController::class, 'index']); // Obtenir toutes les catégories
    Route::get('/saq-produits', [SAQController::class, 'index']);
    Route::get('/saq-produits/{bouteille}', [SAQController::class, 'getBouteilles']);
});



Route::post('/enregistrer', [AuthController::class, 'sauvegarder']);

Route::post('/connexion', [AuthController::class, 'authentifier']);