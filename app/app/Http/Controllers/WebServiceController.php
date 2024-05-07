<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursa;
use App\Models\Circuit;
use App\Models\Checkpoint;
use \Illuminate\Database\QueryException;

class WebServiceController extends Controller
{

    private function sendJsonCurses($curses,$status) {
        return response()->json([
            "curses" => $curses,
            "status" => $status,
        ]);
    }

    private function sendJsonCircuits($circuits,$status) {
        return response()->json([
            "circuits" => $circuits,
            "status" => $status,
        ]);
    }

    private function sendJsonInscriure($status) {
        return response()->json([
            "status" => $status,
        ]);
    }

    public function getCurses($id = null) {
        $cursesArray = [];
        $status = [];
        
        try {
            // Comprueba el parámetro y obtiene todas o una
            if (is_null($id)) {
                $curses = Cursa::with('esport', 'estat')->orderBy('cur_est_id')->get();
            } else {
                $curses = Cursa::with('esport', 'estat')->where('cur_id','=',$id)->orderBy('cur_est_id')->get();
            }
        } catch (QueryException $ex) {
            $status = [
                "code" => "403",
                "description" => "Algo ha salido mal al obtener los datos"
            ];
            return $this->sendJsonCurses([],$status);
        }

        // TODO: Order by estado
        // Participantes inscritos -> Count(*) select inscrits where cursa id....
        // Participantes inscritos <= 

        // Declarar json de curses i el status
        if(!empty($curses)){
            // Omplir el json amb les dades de la cursa
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
                    "inscrits" => 3,  // TODO: contar inscritos
                    "foto" => "foto", // TODO: foto real
                    "web" => $cursa->cur_web
                ];
            }
        }
        $status = [
            "code" => "200",
            "description" => "Ok"
        ];
        return $this->sendJsonCurses($cursesArray,$status);
    }

    public function getCircuits($id = null) {
        $circuitsArray = [];
        $status = [];
        
        try {
            // Comprueba el parámetro y obtiene todas o una
            if (is_null($id)) {
                $circuits = Circuit::get();
            } else {
                $circuits = Circuit::where('cir_id','=',$id)->get();
            }
        } catch (QueryException $ex) {
            $status = [
                "code" => "403",
                "description" => "Algo ha salido mal al obtener los datos"
            ];
            return $this->sendJsonCircuits([],$status);
        }
        
        // Recorre los circuitos
        foreach ($circuits as $circuit) {
            $checkpoints = Checkpoint::where('chk_cir_id','=',$circuit->cir_id)->get();

            // Recorre los checkpoints de un circuito
            $checkpointsArray = [];
            foreach ($checkpoints as $checkpoint) {
                $checkpointsArray[] = [
                    'id' => $checkpoint->chk_id,
                    'pk' => $checkpoint->chk_pk,
                ];
            }

            $circuitsArray[] = [
                "id" => $circuit->cir_id,
                "cursaId" => $circuit->cir_cur_id,
                "num" => $circuit->cir_num,
                "distancia" => $circuit->cir_distancia,
                "nom" => $circuit->cir_nom,
                "preu" => $circuit->cir_preu,
                "temps" => $circuit->cir_temps_estimat,
                "checkpoints" => $checkpointsArray,
            ];
        }
        $status = [
            "code" => "200",
            "description" => "Ok"
        ];
        return $this->sendJsonCircuits($circuitsArray,$status);
    }

    public function inscriure($json = null) {
        if (is_null($json)) {
            $status = [
                "code" => "400",
                "description" => "Es necesario un parametro con los datos a insertar."
            ];
            return $this->sendJsonInscriure($status);
        }
        var_dump($json);

    }
}
