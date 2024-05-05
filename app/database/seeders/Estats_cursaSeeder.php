<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class Estats_cursaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estats_cursa')->insert([
            ['est_nom' => 'En preparació'],
            ['est_nom' => 'Inscripció Oberta'],
            ['est_nom' => 'Inscripció Tancada'],
            ['est_nom' => 'En curs'],
            ['est_nom' => 'Finalitzada'],
            ['est_nom' => 'Cancelada'],
        ]);
    }
}
