<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursa;
use App\Models\Circuit;
use App\Models\Checkpoint;
use \Illuminate\Database\QueryException;

class WebServiceController extends Controller
{

    /***************
     * 
     * Returns
     * 
     ***************/
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

    /***************
     * 
     * Requests
     * 
     ***************/

     // Obtiene todas las cursas
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

    // obtiene todos los circuitos de una cursa
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

    // Obtiene los datos de un participante, id cursa, id circuit e id circuit_categoria
    // Inserta Participant e incripcio
    public function inscriure($json = null) {
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

        // TODO: Validar circuit y cccId
        // Si no trae cursaId o la cursa no existe
        if (!array_key_exists('cursaId',$decode) || Cursa::where('cur_id','=',$decode['cursaId'])->get()->count() == 0 ||
            !array_key_exists('circuitId',$decode) ||
            !array_key_exists('cccId',$decode)) {
            $status = [
                "code" => "402",
                "description" => "Debe haber una cursa existente"
            ];
            return $this->sendJsonInscriure($status);
        }
        $cursaId = $decode['cursaId'];
        $par = $decode['participant'];

        var_dump(strtotime(null));
        var_dump(strtotime('18-01-2002'));

        // Si el participante esta mal
        if (!array_key_exists('nif',            $par) || strlen($par['nif']) != 9 ||
            !array_key_exists('nom',            $par) || strlen($par['nom']) > 50 || strlen($par['nom']) < 2 ||
            !array_key_exists('cognoms',        $par) || strlen($par['cognoms']) > 50 || strlen($par['cognoms']) < 2 ||
            !array_key_exists('data_naixement', $par) || !strtotime($par['data_naixement']) ||
            !array_key_exists('telefon',        $par) || !is_numeric($par['telefon']) || strlen($par['telefon']) != 9 ||
            !array_key_exists('email',          $par) || strlen($par['email']) > 200 || strlen($par['email']) < 10 ||
            !array_key_exists('es_federat',     $par) || ($par['es_federat'] != 1 && $par['es_federat'] != 0 )) {
            $status = [
                "code" => "403",
                "description" => "Algún dato del participante no es correcto"
            ];
            return $this->sendJsonInscriure($status);
        }

        $participant = new Participant;
        $participant->nif = $par['nif'];
        $participant->nom = $par['nom'];
        $participant->cognoms = $par['cognoms'];
        $participant->data_naixement = $par['data_naixement'];
        $participant->telefon = $par['telefon'];
        $participant->email = $par['email'];
        $participant->es_federat = $par['es_federat'];
        $participant->save();

        $inscripcio = new Inscripcio;
        $inscripcio->ins_par_id = $participant->id; // No creo que funcione pero buwno
        $inscripcio->ins_data = "";
        $inscripcio->ins_dorsal = "";
        $inscripcio->ins_retirat = "";
        $inscripcio->ins_bea_id = "";
        $inscripcio->ins_bea_id = "";
// TODO: insertar participant y lo demas

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
        if (!array_key_exists('beaconId',$decode) || !is_numeric($decode['beaconId']) ||
            !array_key_exists('checkpointId',$decode) || !is_numeric($decode['checkpointId']) ||
            !array_key_exists('time',$decode)) {
            $status = [
                "code" => "401",
                "description" => "Debe haber un id de un beacon, id del checkpoint y un tiempo validos."
            ];
            return $this->sendJsonInscriure($status);
        }

        try {
            $checkpoint = Checkpoint::where('chk_id','=',$decode['checkpointId'])->get();
            $beacon = Beacon::where('ins_bea_id','=',$decode['beaconId'])->get();
        } catch (QueryException $ex) {
            $status = [
                "code" => "403",
                "description" => "Algo ha salido mal al obtener los datos"
            ];
            return $this->sendJsonCircuits([],$status);
        }

        $status = [
            "code" => "200",
            "description" => "Todo ok"
        ];
        return $this->sendJsonInscriure($status);
    }
}


/**
 * REGISTRE DE CHECK
 * Time
 * 
 * INSCRIPCION
 * ELLOS
 * par
 * curId
 * CirId 
 *
 * 
 * Nosottros
 * Beacon -> ya existe de antes
 * Dorsal inventado
 * 
 */