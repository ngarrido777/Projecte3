<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursa;
use App\Models\Beacon;
use App\Models\Circuit;
use App\Models\Registre;
use App\Models\Categoria;
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
        ], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);
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



    public function getCircuitsCursaCategoria(Request $post) {
        $circuits = Circuit_Categoria::select('ccc_cir_id')->where('ccc_cat_id',$post['cat'])->get();
        $cirs = Circuit::whereIn('cir_id',$circuits)->where('cir_cur_id',$post['cur_id'])->get();
        return $cirs;
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
        
        if (!is_numeric($id) && !is_null($id)) {
            $status = [
                "code" => "4030",
                "description" => "El parametro debe ser numérico o vacío"
            ];
            return $this->sendJsonCurses([],$status);
        }

        try {
            // Comprueba el parámetro y obtiene todas o una
            if (is_null($id)) {
                $curses = Cursa::with('esport', 'estat')->orderBy('cur_est_id')->get();
            } else {
                $curses = Cursa::with('esport', 'estat')->where('cur_id',$id)->get();
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
                $circuits = Circuit::where('cir_cur_id','=',$id)->get();
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

            $categories = Circuit_Categoria::where('ccc_cir_id',$circuit->cir_id)->get();


            $cats = [];
            foreach ($categories as $key => $value) {
                $cats[] = [
                    'id' => $value->categoria->cat_id,
                    'nom' => $value->categoria->cat_nom
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
                "categories" => $cats
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

        // TODO: Validar circuit y catId
        // Si no trae cursaId o la cursa no existe
        if (!array_key_exists('participant', $decode) ||
            !array_key_exists('cursaId',     $decode) || Cursa::where('cur_id',$decode['cursaId'])->get()->count() == 0 ||
            !array_key_exists('circuitId',   $decode) || Circuit::where('cir_id',$decode['circuitId'])->get()->count() == 0 ||
            !array_key_exists('catId',       $decode) || Categoria::where('cat_id',$decode['catId'])->get()->count() == 0) {
            $status = [
                "code" => "402",
                "description" => "Los datos no son válidos"
            ];
            return $this->sendJsonInscriure($status);
        }
        $cursaId = $decode['cursaId'];
        $circuitId = $decode['circuitId'];
        $catId = $decode['catId'];
        $par = $decode['participant'];


        // Si el participante esta mal
        if (!array_key_exists('nif', $par) || strlen($par['nif']) != 9 ||
            !array_key_exists('nom', $par) || strlen($par['nom']) > 50 || strlen($par['nom']) < 2 ||
            !array_key_exists('email', $par) || strlen($par['email']) > 200 || strlen($par['email']) < 10 ||
            !array_key_exists('telefon', $par) || !is_numeric($par['telefon']) || strlen($par['telefon']) != 9 ||
            !array_key_exists('cognoms', $par) || strlen($par['cognoms']) > 50 || strlen($par['cognoms']) < 2 ||
            (array_key_exists('codiFederat', $par) && ($par['codiFederat'] < 10000 || $par['codiFederat'] > 99999)) ||
            !array_key_exists('dataNaixement', $par) || !strtotime($par['dataNaixement']) || $par['dataNaixement'] >= date('Y-m-d')) {
            $status = [
                "code" => "403",
                "description" => "Algún dato del participante no es correcto"
            ];
            return $this->sendJsonInscriure($status);
        }

        $participant = new Participant;
        $participant->par_nif = $par['nif'];
        $participant->par_nom = $par['nom'];
        $participant->par_cognoms = $par['cognoms'];
        $participant->par_data_naixement = date("Y-m-d", strtotime($par['dataNaixement']));  
        $participant->par_telefon = $par['telefon'];
        $participant->par_email = $par['email'];
        $participant->par_es_federat = array_key_exists('codiFederat', $par);
        $participant->par_num_federat = $par['codiFederat'] ?? null;

        try {
            $participant->save();
        } catch (QueryException $ex) {
            $status = [
                "code" => "400",
                "description" => "No se pudo insertar el participante"
            ];
            return $this->sendJsonInscriure($status);
        }

        $cccId = Circuit_Categoria::select('ccc_id')
            ->where('ccc_cat_id',$decode['catId'])
            ->where('ccc_cir_id',$decode['circuitId'])
            ->get()
        ;

        $inscripcio = new Inscripcio;
        $inscripcio->ins_par_id = $participant->par_id;
        $inscripcio->ins_data = date('Y-m-d'); 
        $inscripcio->ins_dorsal = 314 + $participant->par_id;
        $inscripcio->ins_retirat = 0;
        $inscripcio->ins_bea_id = $participant->par_id;
        $inscripcio->ins_ccc_id = $cccId[0]->ccc_id;
        try {
            $inscripcio->save();
        } catch (QueryException $ex) {
            $participant->delete();
            $status = [
                "code" => "400",
                "description" => "No se pudo insertar la inscripcion"
            ];
            dd($ex->getMessage());
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
            !array_key_exists('cirId',$decode) || !is_numeric($decode['cirId']) ||
            !array_key_exists('catId',$decode) || !is_numeric($decode['catId']) ||
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
            $ccc = Circuit_categoria::where('cat_id','=',$decode['catId'])->where('cir_id','=',$decode['cirId'])->get();
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
        $registre->reg_temps =
            (strtotime($decode['temps']) ? date("Y-m-d", strtotime($decode['temps'])) : date("Y-m-d"));
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