<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;
use App\Models\Pays;
use App\Models\Categorie;
use App\Models\Bouteille;




class SAQController extends Controller
{
    public function __construct()
    {
        Log::debug('SAQController::__construct');
        $this->middleware('admin')->only('index');
    }
    // Récupère les produits de la SAQ et les enregistre dans la table bouteilles
    public function index()
    {
        $client = HttpClient::create();
        $browser = new HttpBrowser($client);

        $url = "https://www.saq.com/fr/produits/vin?product_list_limit=96";
        $crawler = $browser->request('GET', $url);

        // Extraire le nombre total d'items
        $totalItemsNode = $crawler->filter('.toolbar-amount')->text();
        preg_match('/(\d+)$/', $totalItemsNode, $matches);
        $totalItems = isset($matches[1]) ? intval($matches[1]) : 0;

        // Calculer le nombre total de pages
        // $totalPage = ceil($totalItems / 96);
        $totalPage = 1;



        for ($i = 1; $i <= $totalPage; $i++) {
            $produitsBruts = recupererProduitsSaq($i, $browser);
            foreach ($produitsBruts as $produitBrut) {
                $pays = Pays::where('nom', $produitBrut['pays'])->first();
                $categorie = Categorie::where('nom', $produitBrut['categorie'])->first();

                if ($pays && $categorie) {
                    $donneesProduit = [
                        'nom' => $produitBrut['nom'],
                        'photo' => $produitBrut['photo'],
                        'description' => $produitBrut['description'],
                        'annee' => null,
                        'prix' => $produitBrut['prix'],
                        'code_saq' => $produitBrut['code_saq'],
                        'url_saq' => $produitBrut['url_saq'],
                        'pays_id' => $pays->id,
                        'categorie_id' => $categorie->id,
                    ];

                    // Insérer le produit dans la table bouteilles
                    Bouteille::create($donneesProduit);
                }
            }
        }

        // Retourner un simple message de réussite
        return response()->json(['message' => 'Produits enregistrés dans la table bouteilles.']);
    }

    public function getBouteilles($valeur)
    {
        $bouteilles = Bouteille::where('nom','LIKE', '%' . $valeur . '%')->take(5)->get();

        return response()->json($bouteilles);
    }
}
