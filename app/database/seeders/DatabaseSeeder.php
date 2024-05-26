<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(BeaconsSeeder::class);
        $this->call(EsportsCategoriesSeeder::class);
        $this->call(Estats_cursaSeeder::class);
        $this->call(UsuarisSeeder::class);
        $this->call(CursesCircuitsCheckpointsSeeder::class);
        $this->call(Circuits_CategoriesSeeder::class);
        $this->call(InscripcionsRegistresSeeder::class);
    }
}