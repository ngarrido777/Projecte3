<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Session;
use App\Models\Cursa;
use App\Models\Circuit;
use App\Models\Categoria;
use App\Models\Inscripcio;
use App\Models\Participant;
use App\Models\Circuit_Categoria;
use \Illuminate\Database\QueryException;

// Errores
const MSG_INF = 'msg_inf';
const MSG_ADV = 'msg_adv';
const MSG_ERR = 'msg_err';

// Estats
const ESTAT_PREPARACIO = 1;
const ESTAT_OBERTA = 2;
const ESTAT_TANCADA = 3;
const ESTAT_CURS = 4;
const ESTAT_FINALITZADA = 5;
const ESTAT_CANCELADA = 6;
class InscripcioController extends Controller
{
    private function inscriureView($cursa,$cats,$code = null,$mensaje = null,$fields = null) {
        $usu = Session::get('usu');
        return view('inscriure', [
            'data' => [
                'cursa' => $cursa,
                'cats' => $cats
            ],
            'fields' => $fields,
            'message' => ((!is_null($code) && !is_null($code)) ? [
                'type' => $code,
                'text' => $mensaje
            ] : null),
            'usu' => $usu
        ]);
    }

    public function inscriure($id = null)
    {
        if (is_null($c = Cursa::where('cur_id',$id)->first()) || $c->cur_est_id != ESTAT_OBERTA)
            return redirect('/');

        $ins_cur = Inscripcio::whereIn('ins_ccc_id', (function ($query) use ($id) {
            $query->from('circuits_categories')
                ->select('ccc_id')
                ->whereIn('ccc_cir_id', (function ($query) use ($id) {
                    $query->from('circuits')
                        ->select('cir_id')
                        ->where('cir_cur_id', $id);
                }));
        }))->count();

        $fields = [
            'nif' => $_POST['f_nif'] ?? "",
            'nom' => $_POST['f_nom'] ?? "",
            'email' => $_POST['f_email'] ?? "",
            'telefon' => $_POST['f_telefon'] ?? "",
            'cognoms' => $_POST['f_cognoms'] ?? "",
            'federat' => isset($_POST['f_federat']) ?: false,
            'codiFederat' => $_POST['f_num_federat'] ?? "",
            'naix' => $_POST['f_naix'] ?? "",
            'inscrits' => $ins_cur
        ];

        $categories = Categoria::where('cat_esp_id',$c->cur_esp_id)->get();
        if (isset($_POST['f_ins'])) {

            if ($ins_cur >= $c->cur_limit_inscr) {
                $text = "No puedes inscribirte ya que el registro está lleno";
                return $this->inscriureView($c, $categories, MSG_ERR, $text, $fields);
            }

            if (!isset($_POST['f_nif']) || strlen($_POST['f_nif']) != 9)
                $err = "NIF incorrecto";
            elseif (!isset($_POST['f_nom']) || strlen($_POST['f_nom']) > 50 || strlen($_POST['f_nom']) < 2) 
                $err = "NOMBRE incorrecto";
            elseif (!isset($_POST['f_email']) || strlen($_POST['f_email']) > 200 || strlen($_POST['f_email']) < 10)
                $err = "EMAIL incorrecto";
            elseif (!isset($_POST['f_telefon']) || !is_numeric($_POST['f_telefon']) || strlen($_POST['f_telefon']) != 9)
                $err = "TELEFONO incorrecto";
            elseif (!isset($_POST['f_cognoms']) || strlen($_POST['f_cognoms']) > 50 || strlen($_POST['f_cognoms']) < 2)
                $err = "APELLIDOS incorrectos";
            elseif (!((
                    isset($_POST['f_federat']) &&
                    isset($_POST['f_num_federat']) && 
                    is_numeric($_POST['f_num_federat']) && 
                    strlen($_POST['f_num_federat']) == 5)
                    ||
                    (!isset($_POST['f_federat']))
            ))
                $err = "NUMERO DE FEDERADO incorrecto";                    
            elseif (!isset($_POST['f_naix']) || !strtotime($_POST['f_naix']) || $_POST['f_naix'] >= date('Y-m-d'))
                $err = "FECHA incorrecta";
            elseif (!isset($_POST['f_categoria']) || $_POST['f_categoria'] == -1)
                $err = "CATEGORIA incorrecta";
            elseif (!isset($_POST['f_circuit']) || $_POST['f_circuit'] == -1)
                $err = "CIRCUITO incorrecto";

            if (isset($err)) {
                return $this->inscriureView($c, $categories, MSG_ERR, $err, $fields);
            }

            $participant = new Participant;
            $participant->par_nif = $_POST['f_nif'];
            $participant->par_nom = $_POST['f_nom'];
            $participant->par_cognoms = $_POST['f_cognoms'];
            $participant->par_data_naixement = date("Y-m-d", strtotime($_POST['f_naix']));  
            $participant->par_telefon = $_POST['f_telefon'];
            $participant->par_email = $_POST['f_email'];
            if ($participant->par_es_federat = isset($_POST['f_federat'])) {
                $participant->par_num_federat = isset($_POST['f_num_federat']);
            }
            try {
                $participant->save();
            } catch (QueryException $ex) {
                dd($ex->getMessage());
                $text = "No se ha podido completar su registro. [p]";
                return $this->inscriureView($c, $categories, MSG_ERR, $text, $fields);
            }

            $cccId = Circuit_Categoria::select('ccc_id')
                ->where('ccc_cat_id',$_POST['f_categoria'])
                ->where('ccc_cir_id',$_POST['f_circuit'])
                ->first()
            ;

            $inscripcio = new Inscripcio;
            $inscripcio->ins_par_id = $participant->par_id;
            $inscripcio->ins_data = date('Y-m-d'); 
            $inscripcio->ins_retirat = 0;
            $inscripcio->ins_ccc_id = $cccId->ccc_id;

            try {
                $inscripcio->save();
            } catch (QueryException $ex) {
                $participant->delete();
                $text = "No se ha podido completar su registro. [i]";
                return $this->inscriureView($c, $categories, MSG_ERR, $text, $fields);
            }

            $text = "Ya estás registrado!!";
            return $this->inscriureView($c, $categories, MSG_INF, $text, $fields);

        }
        
        return $this->inscriureView($c, $categories, null, null, $fields);
    }

    public function veureresultats($id) {
        $usu = Session::get('usu');
        if (is_null($c = Cursa::where('cur_id',$id)->first())) {
            return redirect('/');
        }
        return view('resultats',[
            'data' => [
                'cursa' => $c
            ],
            'usu' => $usu
        ]);
    }
}

