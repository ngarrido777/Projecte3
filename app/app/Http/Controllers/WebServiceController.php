<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursa;

class WebServiceController extends Controller
{
    public function getCurses($id = null) {
        $curses = array();

        // Comprueba el parámetro y otiene todas o una
        try {
            if (is_null($id)) {
                $curses = Cursa::with('esport', 'estat')->get();
            } else {
                $curses = Cursa::with('esport', 'estat')->where('cur_id','=',$id)->get();
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            switch ($ex->getCode()) {
                case 1045:
                    $code = '403';
                    $msgerror = 'Accés denegat.';
                    break;
                default:
                    $code = '500';
                    $msg = 'Error desconegut.';
                    break;
            }
            return response()->json([
                "response" => [
                    "code" => $code,
                    "description" => $msg
                ]
            ]);
        }

        //Declarar json de curses i error
        $cursesArray = [];
        $error = [];
        if(!empty($curses)){
            //Omplir el json amb les dades de la cursa
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
                    "foto" => "foto", // TODO: foto real
                    "web" => $cursa->cur_web
                ];
            }
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
