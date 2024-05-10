<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursa;
use App\Models\Beacon;
use App\Models\Circuit;
use App\Models\Registre;
use App\Models\Checkpoint;
use App\Models\Inscripcio;
use App\Models\Participant;
use App\Models\Circuit_categoria;
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

        // TODO: Validar circuit y cccId
        // Si no trae cursaId o la cursa no existe
        if (!array_key_exists('participant',$decode) ||
            !array_key_exists('cursaId',    $decode) || Cursa::where('cur_id','=',$decode['cursaId'])->get()->count() == 0 ||
            !array_key_exists('circuitId',  $decode) || !is_numeric('circuitId') ||
            !array_key_exists('cccId',      $decode) || !is_numeric('cccId')) {
            $status = [
                "code" => "402",
                "description" => "Los datos no son válidos"
            ];
            return $this->sendJsonInscriure($status);
        }
        $cursaId = $decode['cursaId'];
        $circuitId = $decode['circuitId'];
        $cccId = $decode['cccId'];
        $par = $decode['participant'];


        // Si el participante esta mal
        if (!array_key_exists('nif',            $par) || strlen($par['nif']) != 9 ||
            !array_key_exists('nom',            $par) || strlen($par['nom']) > 50 || strlen($par['nom']) < 2 ||
            !array_key_exists('cognoms',        $par) || strlen($par['cognoms']) > 50 || strlen($par['cognoms']) < 2 ||
            !array_key_exists('dataNaixement',  $par) || !strtotime($par['dataNaixement']) ||
            !array_key_exists('telefon',        $par) || !is_numeric($par['telefon']) || strlen($par['telefon']) != 9 ||
            !array_key_exists('email',          $par) || strlen($par['email']) > 200 || strlen($par['email']) < 10 ||
            !array_key_exists('esFederat',      $par) || ($par['esFederat'] != 1 && $par['esFederat'] != 0 )) {
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
        $participant->data_naixement = date("Y-m-d", strtotime($par['dataNaixement']));  
        $participant->telefon = $par['telefon'];
        $participant->email = $par['email'];
        $participant->es_federat = $par['esFederat'];
        try {
            $participant->save();
        } catch (QueryException $ex) {
            $status = [
                "code" => "400",
                "description" => "No se pudo insertar el participante"
            ];
            return $this->sendJsonInscriure($status);
        }

        $inscripcio = new Inscripcio;
        $inscripcio->ins_par_id = $participant->par_id;
        $inscripcio->ins_data = date('Y-m-d');
        $inscripcio->ins_dorsal = 314 + $participant->par_id;
        $inscripcio->ins_retirat = 0;
        $inscripcio->ins_bea_id = $participant->par_id; // no reutilizables por ahora
        $inscripcio->ins_ccc_id = $cccId;
        try {
            $inscripcio->save();
        } catch (QueryException $ex) {
            $participant->delete();
            $status = [
                "code" => "400",
                "description" => "No se pudo insertar la inscripcion"
            ];
            return $this->sendJsonInscriure($status);
        }

        $status = [
            "code" => "200",
            "description" => "Todo ok"
        ];
        return $this->sendJsonInscriure($status);
    }
    
    public function participantCheckpoint($json = null) {
        $decode = json_decode($json,true);
        // Si no viene array
        if (!is_array($decode)) {
            $status = [
                "code" => "400",
                "description" => "Necesitamos un array."
            ];
            return $this->sendJsonParticipantCheckpoint($status);
        }
        // Si no trae los datos validos
        if (!array_key_exists('parId',$decode) || !is_numeric($decode['parId']) ||
            !array_key_exists('cccId',$decode) || !is_numeric($decode['cccId']) ||
            !array_key_exists('beaId',$decode) || !is_numeric($decode['beaId']) ||
            !array_key_exists('chkId',$decode) || !is_numeric($decode['chkId']) ||
            !array_key_exists('temps',$decode)) { // Hay que validar el tiempo
            $status = [
                "code" => "401",
                "description" => "Debe haber un id de un beacon, id del checkpoint y un tiempo validos."
            ];
            return $this->sendJsonParticipantCheckpoint($status);
        }

        try {
            $par =       Participant::where('par_id','=',$decode['parId'])->get();
            $ccc = Circuit_categoria::where('ccc_id','=',$decode['cccId'])->get();
            $bea =            Beacon::where('bea_id','=',$decode['beaId'])->get();
            $chk =        Checkpoint::where('chk_id','=',$decode['chkId'])->get();
        } catch (QueryException $ex) {
            $status = [
                "code" => "403",
                "description" => "Algo ha salido mal al conectar con la base de datos"
            ];
            return $this->sendJsonParticipantCheckpoint($status);
        }

        if (count($par) == 0 ||
            count($ccc) == 0 ||
            count($bea) == 0 ||
            count($chk) == 0) {
            $status = [
                "code" => "403",
                "description" => "Alguno de los datos pasados no existen"
            ];
            return $this->sendJsonParticipantCheckpoint($status);
        }

        try {
            $ins = Inscripcio::where('ins_par_id',$par[0]->par_id)
                             ->where('ins_bea_id',$bea[0]->bea_id)  
                             ->where('ins_ccc_id',$ccc[0]->ccc_id)
                             ->get();
        } catch (QueryException $ex) {
            $status = [
                "code" => "403",
                "description" => "No se ha podido recuperar la inscripción"
            ];
            return $this->sendJsonParticipantCheckpoint($status);
        }

        if (count($ins) != 1) {
            $status = [
                "code" => "403",
                "description" => "No existe una inscripción así"
            ];
            return $this->sendJsonParticipantCheckpoint($status);
        }

        $registre = new Registre;
        $registre->reg_temps = date('Y-m-d');
        $registre->reg_ins_id = $ins[0]->ins_id;
        $registre->reg_chk_id = $chk[0]->chk_id;

        try {
            $registre->save();
        } catch (QueryException $ex) {
            $participant->delete();
            $status = [
                "code" => "400",
                "description" => "No se pudo registrar el registro"
            ];
            return $this->sendJsonInscriure($status);
        }

        $status = [
            "code" => "200",
            "description" => "Todo ok"
        ];
        return $this->sendJsonParticipantCheckpoint($status);
    }
}