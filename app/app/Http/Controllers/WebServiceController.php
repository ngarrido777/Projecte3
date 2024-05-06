<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursa;

class WebServiceController extends Controller
{
    public function getCurses()
    {
        $curses = Cursa::with('esport', 'estat')->get();

        foreach ($curses as $cursa) {
            $cursesArray[] = [
                "id" => $cursa->cur_id,
                "nom" => $cursa->cur_nom,
                "dataInici" => $cursa->cur_data_inici,
                "dataFi" => $cursa->cur_data_fi,
                "lloc" => $cursa->cur_lloc,
                "esport" => [
                    "id" => $cursa->esport->esp_id,
                    "nom" => $cursa->esport->esp_nom
                ],
                "estat" => [
                    "id" => $cursa->estat->est_id,
                    "nom" => $cursa->estat->est_nom
                ],
                "descripcio" => $cursa->cur_desc,
                "limit" => $cursa->cur_limit_inscr,
                "foto" => $cursa->cur_foto,
                "web" => $cursa->cur_web
            ];
        }

        return response()->json([
            "curses" => $cursesArray,
            "response" => [
                "code" => "200",
                "description" => "Todo piola"
            ]
        ]);
    }
}
