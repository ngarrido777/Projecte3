<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Esport;
use App\Models\Estat_cursa;
use App\Models\Cursa;
use \Illuminate\Database\QueryException;

class InscripcioController extends Controller
{
    public function inscriure($id = null)
    {
        if (!is_numeric($id)) {
            return redirect('/');
        }

        $cursa = Cursa::where('cur_id',$id)->get();
        if (count($cursa) <= 0) {
            return redirect('/');
        }

        return view('inscriure', [
            'cursa' => $cursa[0]
        ]);
    }
}
