<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class Circuits_CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('circuits_categories')->insert([
            ['ccc_id' => '1', 'ccc_cir_id' => 1,'ccc_cat_id' => 1],
            ['ccc_id' => '2', 'ccc_cir_id' => 1,'ccc_cat_id' => 2],
            ['ccc_id' => '3', 'ccc_cir_id' => 1,'ccc_cat_id' => 4],
            ['ccc_id' => '4', 'ccc_cir_id' => 2,'ccc_cat_id' => 3],
            ['ccc_id' => '5', 'ccc_cir_id' => 2,'ccc_cat_id' => 4],
            ['ccc_id' => '6', 'ccc_cir_id' => 3,'ccc_cat_id' => 5],
            ['ccc_id' => '7', 'ccc_cir_id' => 3,'ccc_cat_id' => 6],
            ['ccc_id' => '8', 'ccc_cir_id' => 4,'ccc_cat_id' => 6],
            ['ccc_id' => '9', 'ccc_cir_id' => 5,'ccc_cat_id' => 2],
            ['ccc_id' => '10', 'ccc_cir_id' => 5,'ccc_cat_id' => 3],
            ['ccc_id' => '11', 'ccc_cir_id' => 5,'ccc_cat_id' => 4],
            ['ccc_id' => '12', 'ccc_cir_id' => 6,'ccc_cat_id' => 5],
            ['ccc_id' => '13', 'ccc_cir_id' => 6,'ccc_cat_id' => 6],
            ['ccc_id' => '14', 'ccc_cir_id' => 7,'ccc_cat_id' => 5],
            ['ccc_id' => '15', 'ccc_cir_id' => 7,'ccc_cat_id' => 6],
            ['ccc_id' => '16', 'ccc_cir_id' => 8,'ccc_cat_id' => 5],
            ['ccc_id' => '17', 'ccc_cir_id' => 8,'ccc_cat_id' => 6],
        ]);
    }
}
