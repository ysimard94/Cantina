<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PaysSeeder;
use App\Models\Cellier;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\CategorieSeeder;
use App\Models\Role;
use App\Models\Utilisateur;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PaysSeeder::class,
            CategorieSeeder::class,
            RolesTableSeeder::class
        ]);

        $adminRole = Role::where('nom', 'admin')->first();
        $utilisateurRole = Role::where('nom', 'utilisateur')->first();

        $utilisateur = Utilisateur::create([
            'nom' => 'Test User',
            'courriel' => 'test@example.com',
            'mdp' => Hash::make('password'),
        ]);

        //  Créer un cellier pour le test utilisateur 
        $cellier = new Cellier;
        $cellier->nom = "Cellier de " . $utilisateur->nom;
        $cellier->utilisateur_id = $utilisateur->id;
        $cellier->save();

  

        // Créer un admin utilisateur
        $admin = Utilisateur::create([
            'nom' => 'Admin',
            'courriel' => 'admin@cantina.com',
            'mdp' => Hash::make('password'),
        ]);

        //  Créer un cellier pour l'admin 
        $cellier = new Cellier;
        $cellier->nom = "Cellier de " . $admin->nom;
        $cellier->utilisateur_id = $admin->id;
        $cellier->save();

         // Attacher a l'utilisateur admin le role admin
         if ($adminRole) {
            $admin->roles()->attach($adminRole);
        }
         // Attacher a l'utilisateur test le role utilisateur
         if ($utilisateurRole) {
            $utilisateur->roles()->attach($utilisateurRole);
        }

    }
}
