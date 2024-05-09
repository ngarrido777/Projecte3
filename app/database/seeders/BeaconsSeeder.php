<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class BeaconsSeeder extends Seeder
{
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $beacons = [];
        for ($i=0; $i < 20000; $i++) { 
            $code = $this->generateRandomString(30);
            $beacons[] = [
                'bea_code' => $code   
            ];
        }
        DB::table('beacons')->insert($beacons);
    }
}
