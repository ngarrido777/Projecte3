<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeaconsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('beacons')->insert([
            ['bea_code' => 'bR1S7!Gc(BS!?%-uY/_K)Te!$m9j6b'],
            ['bea_code' => '+M1N;3cvkMZ:fThS$[WnvH&{J2G9:$'],
            ['bea_code' => 'y;AcyeqcMaCUB[K_+F:gCnJ&=:;v(4'],
            ['bea_code' => 'LWtWL{j&m[8}e5G1iMZAywJyif};%h'],
        ]);
    }
}
