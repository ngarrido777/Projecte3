<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursa;
use App\Models\Circuit;
use App\Models\Checkpoint;
use \Illuminate\Database\QueryException;

class WebServiceController extends Controller
{

    private function validateNif($nif) {
        if (strlen($nif) != 9)
            return false;
        return true;
    }

    private function validateNom($nom) {
        if (strlen($nom) > 20 or strlen($nom) < 2)
            return false;
        return true;
    }

    private function validateTime($time) {
        // TODO
        return true;
    }
    

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

    private function sendJsonParticipantCheckpoint($status) {
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
        $decode = json_decode($json,true);
        // Si no trae un array
        if (!is_array($decode)) {
            $status = [
                "code" => "401",
                "description" => "Por favor envía un array válido"
            ];
            return $this->sendJsonInscriure($status);
        }
        // Si no trae participant
        if (!array_key_exists('participant',$decode)) {
            $status = [
                "code" => "401",
                "description" => "Debe haber un participante con información válida."
            ];
            return $this->sendJsonInscriure($status);
        }

        // Si no trae cursaId o la cursa no existe
        if (!array_key_exists('cursaId',$decode) || Cursa::where('cur_id','=',$decode['cursaId'])->get()->count() == 0) {
            $status = [
                "code" => "402",
                "description" => "Debe haber una cursa existente"
            ];
            return $this->sendJsonInscriure($status);
        }
        $cursaId = $decode['cursaId'];
        $par = $decode['participant'];

        // Si no trae nif valid
        if (!array_key_exists('nif',$par) || !$this->validateNif($par['nif'])) {
            $status = [
                "code" => "403",
                "description" => "Debe haber una cursa existente"
            ];
            return $this->sendJsonInscriure($status);
        }

        // Si no trae nom o nif valid
        if (!array_key_exists('nom',$par) || !$this->validateNom($par['nom']) ||
            !array_key_exists('nif',$par) || !$this->validateNif($par['nif'])) {
            $status = [
                "code" => "403",
                "description" => "El nombre debe ser mayor de 2 y menos de 20 caracteres"
            ];
            return $this->sendJsonInscriure($status);
        }

        // var_dump(strlen($decode['cano']));

        // $data = [
        //     'nif' => $json['participant']['nif']
        // ];

        // $cursaId = "";
        // $participant = new Participant;
        // $participant->nif  = $nif;
        // $participant->nom = $nom;
        // $participant->cognoms = $cognoms;
        // $participant->data_naixement = $data_naixement;
        // $participant->telefon = $telefon;
        // $participant->email = $email;
        // $participant->es_federat = $es_federat;

    }
    
    public function participantCheckpoint($json = null) {
        $decode = json_decode($json,true);
        // Si no viene array
        if (!is_array($decode)) {
            $status = [
                "code" => "400",
                "description" => "Necesitamos un array."
            ];
            return $this->sendJsonInscriure($status);
        }
        // Si no trae los datos validos
        if (!array_key_exists('beaconId',$decode) || !is_numerid($decode['beaconId']) ||
            !array_key_exists('checkpointId',$decode) || !is_numerid($decode['checkpointId']) ||
            !array_key_exists('time',$decode) || !validateTime($decode['time'])) {
            $status = [
                "code" => "401",
                "description" => "Debe haber un id de un beacon, id del checkpoint y un tiempo validos."
            ];
            return $this->sendJsonInscriure($status);
        }
        
        $status = [
            "code" => "200",
            "description" => "Todo ok"
        ];
        return $this->sendJsonInscriure($status);
    }
}
