<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\File;
use App\Models\User;
use App\Models\Column;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Dataset;
use App\Models\Analysis;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         // Créer 10 utilisateurs
         User::factory(10)->create();

         // Créer 20 datasets et chaque dataset aura entre 2 à 5 colonnes et entre 1 à 3 fichiers
         Dataset::factory(20)
             ->has(Column::factory()->count(rand(2, 5)))
             ->has(File::factory()->count(rand(1, 3)))
             ->create();
 
         // Créer 30 analyses, 50 commentaires et 50 notes aléatoirement liés à des utilisateurs et datasets
         Analysis::factory(30)->create();
         Comment::factory(50)->create();
         Rating::factory(50)->create();
    }
}
