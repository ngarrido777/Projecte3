<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UsuarisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuaris')->insert([
            ['usr_login' => 'ngarrido', 'usr_password' => '1234', 'usr_admin' => 1],
            ['usr_login' => 'dcano',    'usr_password' => '1234', 'usr_admin' => 1],
            ['usr_login' => 'aparera',  'usr_password' => '1234', 'usr_admin' => 0],
            ['usr_login' => 'acarrillo','usr_password' => '1234', 'usr_admin' => 0],
        ]);
    }
}
