<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Esport;
use App\Models\Estat_cursa;

class CreaciocursaController extends Controller
{
    public function creaciocurses()
    {
        $esports = Esport::all();
        $esp_names = array();
        foreach ($esports as $key => $e) {
            $esp_names[$e->esp_id] = $e->esp_nom;
        }

    return view('creaciocurses', [
        'esports' => $esp_names,
    ]);
    }
}
