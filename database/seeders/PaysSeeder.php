<?php

namespace Database\Seeders;

use App\Models\Pays;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Seeder;

class PaysSeeder extends Seeder
{

    public function getCountriesInFrench()
    {
        $reponse = Http::withOptions([
            'verify' => base_path('certs/cacert.pem')
        ])->get('https://restcountries.com/v3.1/all?fields=name,translations');
    
        $pays = $reponse->json();
    
        $paysFr = [];
    
        foreach ($pays as $pays_item) {
            if (isset($pays_item['translations']['fra']['common'])) {
                $paysFr[] = $pays_item['translations']['fra']['common'];
            }
        }
    
        return $paysFr;
    }

    public function run()
    {
        $paysFr = $this->getCountriesInFrench();

        foreach ($paysFr as $nom) {
            Pays::factory()->create(['nom' => $nom]);
        }
    }
}