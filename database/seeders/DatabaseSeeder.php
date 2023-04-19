<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PaysSeeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\CategorieSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PaysSeeder::class,
        ]);

        $this->call([
            CategorieSeeder::class,
        ]);

        \App\Models\Utilisateur::create([
            'nom' => 'Test User',
            'courriel' => 'test@example.com',
            'mdp' => Hash::make('password'),
        ]);
    }
}
