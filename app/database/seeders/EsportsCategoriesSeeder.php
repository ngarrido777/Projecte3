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
        $esportId = DB::table('esports')->insertGetId(['esp_nom' => 'Ciclisme']);

        DB::table('categories')->insert([
            ['cat_esp_id' => $esportId, 'cat_nom' => 'infantil'],
            ['cat_esp_id' => $esportId, 'cat_nom' => 'cadet'],
            ['cat_esp_id' => $esportId, 'cat_nom' => 'junior'],
            ['cat_esp_id' => $esportId, 'cat_nom' => 'senior'],
        ]);

        $esportId = DB::table('esports')->insertGetId(['esp_nom' => 'Running']);

        DB::table('categories')->insert([
            ['cat_esp_id' => $esportId, 'cat_nom' => 'Casual'],
            ['cat_esp_id' => $esportId, 'cat_nom' => 'Profesional'],
        ]);
    }
}
