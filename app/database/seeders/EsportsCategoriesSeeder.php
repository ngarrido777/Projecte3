<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class EsportsCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('esports')->insert([
            ['esp_id' => 1,'esp_nom' => 'Ciclisme'],
            ['esp_id' => 2,'esp_nom' => 'Running']
        ]);

        DB::table('categories')->insert([
            ['cat_id' => 1,'cat_esp_id' => 1, 'cat_nom' => 'infantil'],
            ['cat_id' => 2,'cat_esp_id' => 1, 'cat_nom' => 'cadet'],
            ['cat_id' => 3,'cat_esp_id' => 1, 'cat_nom' => 'junior'],
            ['cat_id' => 4,'cat_esp_id' => 1, 'cat_nom' => 'senior'],

            ['cat_id' => 5,'cat_esp_id' => 2, 'cat_nom' => 'Casual'],
            ['cat_id' => 6,'cat_esp_id' => 2, 'cat_nom' => 'Profesional']
        ]);
    }
}
