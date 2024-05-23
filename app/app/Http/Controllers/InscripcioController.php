<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
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

class InscripcioController extends Controller
{
    private function inscriureView($cursa,$cats,$code = null,$mensaje = null,$fields = null) {
        return view('inscriure', [
            'data' => [
                'cursa' => $cursa,
                'cats' => $cats
            ],
            'fields' => $fields,
            'message' => ((!is_null($code) && !is_null($code)) ? [
                'type' => $code,
                'text' => $mensaje
            ] : null)
        ]);
    }

    public function inscriure($id = null)
    {
        if (!is_numeric($id) || count($c = Cursa::where('cur_id',$id)->get()) == 0)
            return redirect('/');

        $fields = [
            'nif' => isset($_POST['f_nif']) ? $_POST['f_nif'] : "",
            'nom' => isset($_POST['f_nom']) ? $_POST['f_nom'] : "",
            'email' => isset($_POST['f_email']) ? $_POST['f_email'] : "",
            'telefon' => isset($_POST['f_telefon']) ? $_POST['f_telefon'] : "",
            'cognoms' => isset($_POST['f_cognoms']) ? $_POST['f_cognoms'] : "",
            'federat' => isset($_POST['f_federat']) ? true : false,
            'codiFederat' => isset($_POST['f_num_federat']) ? $_POST['f_num_federat'] : "",
            'naix' => isset($_POST['f_naix']) ? $_POST['f_naix'] : ""
        ];

        $categories = Categoria::where('cat_esp_id',$c[0]->cur_esp_id)->get();
        if (isset($_POST['f_ins'])) {
            if (!isset($_POST['f_nif']) || strlen($_POST['f_nif']) != 9 ||
                !isset($_POST['f_nom']) || strlen($_POST['f_nom']) > 50 || strlen($_POST['f_nom']) < 2 ||
                !isset($_POST['f_email']) || strlen($_POST['f_email']) > 200 || strlen($_POST['f_email']) < 10 ||
                !isset($_POST['f_telefon']) || !is_numeric($_POST['f_telefon']) || strlen($_POST['f_telefon']) != 9 ||
                !isset($_POST['f_cognoms']) || strlen($_POST['f_cognoms']) > 50 || strlen($_POST['f_cognoms']) < 2 ||
                !(isset($_POST['f_federat']) &&
                    isset($_POST['f_num_federat']) &&
                    is_numeric($_POST['f_num_federat']) &&
                    strlen($_POST['f_num_federat']) == 5) ||
                !isset($_POST['f_naix']) || !strtotime($_POST['f_naix']) || $_POST['f_naix'] >= date('Y-m-d') ||
                !isset($_POST['f_categoria']) || $_POST['f_categoria'] == -1 ||
                !isset($_POST['f_circuit']) || $_POST['f_circuit'] == -1
                ) {
                    $text = "Has insertado mal algún dato, por favor revisalo. ";
                    return $this->inscriureView($c[0], $categories, MSG_ERR, $text, $fields);
            }

            $participant = new Participant;
            $participant->nif = $_POST['f_nif'];
            $participant->nom = $_POST['f_nom'];
            $participant->cognoms = $_POST['f_cognoms'];
            $participant->data_naixement = date("Y-m-d", strtotime($_POST['f_naix']));  
            $participant->telefon = $_POST['f_telefon'];
            $participant->email = $_POST['f_email'];
            $participant->es_federat = isset($_POST['f_federat']);

            try {
                $participant->save();
            } catch (QueryException $ex) {
                $text = "No se ha podido completar su registro.";
                return $this->inscriureView($c[0], $categories, MSG_ERR, $text, $fields);
            }

            $cccId = Circuit_Categoria::select('ccc_id')
                ->where('ccc_cat_id',$_POST['f_categoria'])
                ->where('ccc_cir_id',$_POST['f_circuit'])
                ->get()
            ;

            $inscripcio = new Inscripcio;
            $inscripcio->ins_par_id = $participant->par_id;
            $inscripcio->ins_data = date('Y-m-d'); 
            $inscripcio->ins_retirat = 0;
            $inscripcio->ins_ccc_id = $cccId[0]->ccc_id;

            try {
                $inscripcio->save();
            } catch (QueryException $ex) {
                $participant->delete();
                $text = "No se ha podido completar su registro.";
                return $this->inscriureView($c[0], $categories, MSG_ERR, $text, $fields);
            }

            $text = "Ya estás registrado!!";
            return $this->inscriureView($c[0], $categories, MSG_INF, $text, $fields);

        }
        
        return $this->inscriureView($c[0], $categories, null, null, $fields);
    }
}

