<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class InscripcionsRegistresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('participants')->insert([
            [
                'par_id' => '1',
                'par_nif' => '00000000A',
                'par_nom' => 'Carlos',
                'par_cognoms' => 'Escudero',
                'par_data_naixement' => '2001-10-10',
                'par_telefon' => '600000000',
                'par_email' => 'cescudero@gmail.com'
            ],
            [
                'par_id' => '2',
                'par_nif' => '11111111A',
                'par_nom' => 'Artur',
                'par_cognoms' => 'Udatsnoi',
                'par_data_naixement' => '2009-01-05',
                'par_telefon' => '611111111',
                'par_email' => 'audatsnoi@gmail.com'
            ],
            [
                'par_id' => '3',
                'par_nif' => '44444444A',
                'par_nom' => 'Marc',
                'par_cognoms' => 'Serra',
                'par_data_naixement' => '1999-03-12',
                'par_telefon' => '619191222',
                'par_email' => 'mserra@gmail.com'
            ],
            [
                'par_id' => '4',
                'par_nif' => '55555555A',
                'par_nom' => 'Jawg',
                'par_cognoms' => 'Nawgson',
                'par_data_naixement' => '2006-05-01',
                'par_telefon' => '655566123',
                'par_email' => 'jnawgson@gmail.com'
            ],
        ]);

        DB::table('inscripcions')->insert([
            [
                'ins_id' => '1',
                'ins_par_id' => '1',
                'ins_data' => '2024-01-01',
                'ins_dorsal' => '500',
                'ins_bea_id' => '1',
                'ins_ccc_id' => '14'
            ],
            [
                'ins_id' => '2',
                'ins_par_id' => '2',
                'ins_data' => '2024-01-01',
                'ins_dorsal' => '501',
                'ins_bea_id' => '2',
                'ins_ccc_id' => '15'
            ],
            [
                'ins_id' => '3',
                'ins_par_id' => '3',
                'ins_data' => '2024-01-01',
                'ins_dorsal' => '502',
                'ins_bea_id' => '3',
                'ins_ccc_id' => '16'
            ],
            [
                'ins_id' => '4',
                'ins_par_id' => '4',
                'ins_data' => '2024-01-01',
                'ins_dorsal' => '503',
                'ins_bea_id' => '4',
                'ins_ccc_id' => '17'
            ],
            [
                'ins_id' => '5',
                'ins_par_id' => '1',
                'ins_data' => '2024-01-01',
                'ins_dorsal' => '504',
                'ins_bea_id' => '5',
                'ins_ccc_id' => '17'
            ],
            [
                'ins_id' => '6',
                'ins_par_id' => '4',
                'ins_data' => '2024-01-01',
                'ins_dorsal' => '505',
                'ins_bea_id' => '6',
                'ins_ccc_id' => '15'
            ],
        ]);

        DB::table('registres')->insert([
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))),
                'reg_ins_id' => '1',
                'reg_chk_id' => '1'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (7 * 60)),
                'reg_ins_id' => '1',
                'reg_chk_id' => '2'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (10 * 60)),
                'reg_ins_id' => '1',
                'reg_chk_id' => '3'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (13 * 60)),
                'reg_ins_id' => '1',
                'reg_chk_id' => '4'
            ],

            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))),
                'reg_ins_id' => '2',
                'reg_chk_id' => '1'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (15 * 60)),
                'reg_ins_id' => '2',
                'reg_chk_id' => '2'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (18 * 60)),
                'reg_ins_id' => '2',
                'reg_chk_id' => '3'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))),
                'reg_ins_id' => '6',
                'reg_chk_id' => '1'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (5 * 60)),
                'reg_ins_id' => '6',
                'reg_chk_id' => '2'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (6 * 60)),
                'reg_ins_id' => '6',
                'reg_chk_id' => '3'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (8 * 60)),
                'reg_ins_id' => '6',
                'reg_chk_id' => '4'
            ],


            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))),
                'reg_ins_id' => '3',
                'reg_chk_id' => '1'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (26 * 60)),
                'reg_ins_id' => '3',
                'reg_chk_id' => '2'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (30 * 60)),
                'reg_ins_id' => '3',
                'reg_chk_id' => '3'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (39 * 60)),
                'reg_ins_id' => '3',
                'reg_chk_id' => '4'
            ],

            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))),
                'reg_ins_id' => '4',
                'reg_chk_id' => '1'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (21 * 60)),
                'reg_ins_id' => '4',
                'reg_chk_id' => '2'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))),
                'reg_ins_id' => '5',
                'reg_chk_id' => '1'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (15 * 60)),
                'reg_ins_id' => '5',
                'reg_chk_id' => '2'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (23 * 60)),
                'reg_ins_id' => '5',
                'reg_chk_id' => '3'
            ],
            [
                'reg_temps' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (28 * 60)),
                'reg_ins_id' => '5',
                'reg_chk_id' => '4'
            ],
        ]);
    }
}
