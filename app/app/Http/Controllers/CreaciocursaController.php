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
        $estat_cursa = Estat_cursa::all();

    return view('creaciocurses', ['esports'=>$esports,'estats_cursa'=>$estat_cursa]);
    }
}
