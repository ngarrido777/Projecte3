<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursa;

class WebServiceController extends Controller
{
    public function getCurses(Request $request)
    {
        //Obtebir curses
        $curses = Cursa::with('esport', 'estat')->get();
        //Declarar json de curses i error
        $cursesArray = [];
        $error = [];
        if(!empty($curses)){
            //Omplir el json amb les dades de la cursa
            foreach ($curses as $cursa) {
                $cursesArray = [
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
                    "foto" => "foto"/*$cursa->cur_foto*/,
                    "web" => $cursa->cur_web
                ];
            }
            $error = [
                "code" => "200",
                "description" => "Ok"
            ];
        }else{
            $error = [
                "code" => "200",
                "description" => "Ok"
            ];
        }
        //Enviar json amb els errors i les curses
        return response()->json([
            "curses" => $cursesArray,
            "response" => $error,
        ]);
    }

    public function getCircuits(Request $request)
    {
        $cursaId = $request->json('cursaId');

        $circuits;

        return response()->json([
            "circuits" => $circuits,
            "repsonse" => [
                "code" => "200",
                "description" => "Todo piola"
            ]
        ]);
    }
}
