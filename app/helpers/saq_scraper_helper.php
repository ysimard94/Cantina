<?php
use Symfony\Component\DomCrawler\Crawler;


function recupererProduitsSaq($i, $browser)
{
    $produits = [];

    $url = "https://www.saq.com/fr/produits/vin?p=$i&product_list_limit=96";

    // Request the URL and get a new Crawler instance
    $crawler = $browser->request('GET', $url);

    // Trouver tous les éléments avec la classe 'product-item'
    $itemProduit = $crawler->filter('.product-item');

    // Itérer à travers les éléments du produit
    $itemProduit->each(function (Crawler $itemProduit) use (&$produits) {
        // ... (the rest of your code remains unchanged)
        $nom = trim($itemProduit->filter('.product-item-link')->text());

        // Extraire l'année du nom du produit
        preg_match('/\b(\d{4})\b/', $nom, $matches);
        $annee = isset($matches[1]) ? intval($matches[1]) : null;
  
        
        // Extraire les informations du produit
        $categorieETpays = explode("|", $itemProduit->filter('.product-item-identity-format span')->first()->text());
        $categorie = trim($categorieETpays[0]);
        $pays = trim($categorieETpays[2]);

       
        $photo = $itemProduit->filter('.product-image-photo')->attr('src');
        $code_saq = trim($itemProduit->filter('.saq-code span')->last()->text());
        $description = trim($itemProduit->filter('.product.details')->text());
        
        // Extraire le prix du produit
        $prix = number_format(floatval(preg_replace('/[^\d.]/', '', $itemProduit->filter('.price-wrapper .price')->text())) / 100, 2);
        
        // Extraire l'url du produit
        $url_saq = $itemProduit->filter('.product-item-link')->attr('href');

        // Extraire les notes du produit
        $noteNode = $itemProduit->filter('.rating-result span');

        if ($noteNode->count() > 0) {
            $ratingStyle = $noteNode->attr('style');
            preg_match('/width:\s*(\d+(\.\d+)?)%/', $ratingStyle, $matches);
            $note = isset($matches[1]) ? floatval($matches[1]) : 0;
        } else {
            $note = 0;
        }

        // Extraire le nombre de notes du produit
        $nbr_notes_Node = $itemProduit->filter('.reviews-actions a');
        $nbr_notes = $nbr_notes_Node->count() > 0 ? intval(trim($nbr_notes_Node->text(), '()')) : 0;

        // Nettoyer la description
        $description = preg_replace('/\s+/', ' ', $description);

        // Ajouter le produit à la liste
        $produits[] = [
            'nom' => $nom,
            'photo' => $photo,
            'description' => $description,
            'annee' => $annee,
            'prix' => $prix,
            'note' => $note,
            'code_saq' => $code_saq,
            'nbr_notes' => $nbr_notes,
            'url_saq' => $url_saq,
            'pays' => $pays,
            'categorie' => $categorie,
        ];

    });

     // Retourner la liste des produits
    return $produits;
}

