<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categorie::factory()->createMany([
            [
                'nom' => 'Vin rouge',
            ],
            [
                'nom' => 'Vin blanc',
            ],
            [
                'nom' => 'Vin rosé',
            ],
        ]);
    }
    
}
