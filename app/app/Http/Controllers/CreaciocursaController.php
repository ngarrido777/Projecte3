<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Esport;
use App\Models\Estat_cursa;
use App\Models\Cursa;
use App\Models\Usuari;
use App\Models\Categoria;
use App\Models\Inscripcio;
use App\Models\Checkpoint;
use App\Models\Circuit_categoria;
use App\Models\Circuit;
use Session;
use \Illuminate\Database\QueryException;
use \Illuminate\Support\Facades\DB;

// Estats
const ESTAT_PREPARACIO = 1;
const ESTAT_OBERTA = 2;
const ESTAT_TANCADA = 3;
const ESTAT_CURS = 4;
const ESTAT_FINALITZADA = 5;
const ESTAT_CANCELADA = 6;

class CreaciocursaController extends Controller
{
    public function validar($ok, $errors, $ultims_camps, $request)
    {
        //Validar les dades de la cursa
        //Validar nom
        $nom = $_POST["c_nom"];
        $ultims_camps["l_nom"] = $nom;
        if (strlen($nom) > 50 || strlen($nom) <= 0) {
            $errors['e_nom'] = 'La mida del nom no es correcte';
            $ok = false;
        }
        //Validar data inici
        $data_inici = $_POST["c_data_inici"];
        $ultims_camps["l_data_inici"] = $data_inici;
        //Validar data fi
        $data_fi = $_POST["c_data_fi"];
        $ultims_camps["l_data_fi"] = $data_fi;
        //Validar data inici < data fi
        if (!($data_inici < $data_fi)) {
            $errors['e_data_fi'] = 'La data de inici ha de ser anterior a la data de fi';
            $ok = false;
        }
        //Validar lloc
        $lloc = $_POST["c_lloc"];
        $ultims_camps["l_lloc"] = $lloc;
        if (strlen($lloc) > 20 || strlen($lloc) <= 0) {
            $errors['e_lloc'] = 'La mida del lloc no es correcte';
            $ok = false;
        }
        //Validar esport
        $esport = '';
        if (!isset($_POST["c_esport"])) {
            $errors['e_esport'] = 'Indica un esport';
            $ok = false;
        } else {
            $id_esport = $_POST["c_esport"];
            $ultims_camps["l_esport"] = $id_esport;
            $esport = Esport::where('esp_id', $id_esport)->first();
        }
        //Crear l'estat de la cursa
        $estat = Estat_cursa::where('est_id', 1)->first();
        //Validar descripccio
        $descripccio = $_POST["c_descripccio"];
        $ultims_camps["l_descripccio"] = $descripccio;
        if (strlen($descripccio) > 1000) {
            $errors['e_descripccio'] = 'La mida de la descripccio no es correcte';
            $ok = false;
        }
        //Validar limit inscrits
        $limit = $_POST["c_limit"];
        $ultims_camps["l_limit"] = $limit;
        if(!is_numeric($limit))
        {
            $errors['e_limit'] = 'El limit ha de ser numeric';
            $ok = false;
        }
        if (!is_numeric($limit) || $limit < 10) {
            $errors['e_limit'] = 'El limit ha de ser un enter i de minim 10 persones';
            $ok = false;
        }
        //Validar imatge
        $foto = null;
        if ($request->hasFile('c_foto') && $request->file('c_foto')->isValid()) {
            $file = $request->file('c_foto');
            $size = getimagesize($file);
            //Validar mida de la imatge sense codificar a base64
            if ($file->getSize() <= 5000000){
                if ($size) {
                    $foto = base64_encode(file_get_contents($file->getRealPath()));
                    //$ultims_camps["l_foto"] = $file;
                } else {
                    $errors['e_foto'] = 'Error en el format de la imatge';
                    $ok = false;
                }
            } else {
                $errors['e_foto'] = 'Error en la mida de la imatge maxim 5M';
                $ok = false;
            }
        } else {
            $errors['e_foto'] = 'Error en carregar la imatge';
            $ok = false;
        }
        //Validar web
        $web = $_POST["c_web"];
        $ultims_camps["l_web"] = $web;
        if (strlen($web) > 200) {
            $errors['e_web'] = 'La mida de la web no es correcte';
            $ok = false;
        }

        $circuits = array();
        $total_chk = 0;
        if(isset($request["cc_dist"])){
            for ($i = 0; $i < count($request["cc_dist"]); $i++) {

                if (!isset($request["cc_dist"][$i]) ||
                    !isset($request["cc_nom"][$i]) ||
                    !isset($request["cc_preu"][$i]))
                {
                    $ok = false;
                    $errors['e_circuit'] = 'Revisa els circuits';
                }

                if($request["cc_dist"][$i] <= 0){
                    $ok = false;
                    $errors['e_circuit'] = 'La distancia del circuit no pot ser negativa o 0';
                }

                if($request["cc_preu"][$i] < 0){
                    $ok = false;
                    $errors['e_circuit'] = 'El preu del circuit no pot ser negatiu';
                }

                if($request["cc_temps"][$i] < 0){
                    $ok = false;
                    $errors['e_circuit'] = 'El temps del circuit no pot ser negatiu';
                }

                $circuits[$i] = array(
                    "cc_dist" => $request["cc_dist"][$i],
                    "cc_nom" => $request["cc_nom"][$i],
                    "cc_preu" => $request["cc_preu"][$i],
                    "cc_temps" => $request["cc_temps"][$i],
                    "cc_punt_k" => array()
                );
                
                $qt_chk_circuit = $request["cc_qt_chk"][$i]; // <- Cuantos checkpoints tiene el circuito iterado
                $contador_chk = 0;
                $tmp = $total_chk;
                for ($total_chk; $total_chk < $tmp + $qt_chk_circuit; $total_chk++) {
                    if ($ok && !isset($request['cc_punt_k'][$total_chk])) {
                        $ok = false;
                        $errors['e_circuit'] = 'Revisa els checkpoints';
                    }

                    if ($request['cc_punt_k'][$total_chk] < 0){
                        $ok = false;
                        $errors['e_circuit'] = 'El punt kilometric no pot ser negatiu';
                    }

                    $circuits[$i]['cc_punt_k'][] = $request['cc_punt_k'][$total_chk];
                }
                
                $ultims_camps["circuits"] = $circuits;
            }
        }else{
            $errors['e_circuit'] = 'No hi han circuits';
        }

        $dades = array($nom, $data_inici, $data_fi, $lloc, $esport, $estat, $descripccio, $limit, $foto, $web, $circuits);
        return array($ok, $errors, $ultims_camps, $dades);
    }

    public function asignarparticipant($id = null)
    {
        $ok = true;
        $usu = Session::get('usu');
        if ($usu == null || !$usu->usr_admin || is_null($id) || is_null($c = Cursa::where('cur_id',$id)->first()) || $c->cur_est_id != ESTAT_CURS)
            return redirect('/');
        
        //Array de errors
        $errors = array(
            'e_esport' => '',
        );
        
        $cats = Categoria::whereIn('cat_id', (function ($query) use ($id) {
            $query->from('circuits_categories')
                ->select('ccc_cat_id')
                ->whereIn('ccc_cir_id', (function ($query) use ($id) {
                    $query->from('circuits')
                        ->select('cir_id')
                        ->where('cir_cur_id', $id);
                }));
        }))->get();


        $inscripcions = array();
        $cat = null;
        $cir = null;

        if (isset($_POST['f_recep'])) {
            $ccc = Circuit_categoria::where('ccc_cir_id', $_POST['f_circuit'])->where('ccc_cat_id', $_POST['f_categoria'])->first();
            $inscripcions = Inscripcio::where('ins_ccc_id', $ccc->ccc_id)->get();
            $cat = $ccc->categoria;
            $cir = $ccc->circuit;
        }

        if (isset($_POST['f_recep_si'])) {
            $ccc = Circuit_categoria::where('ccc_cir_id', $_POST['selected_cir'])->where('ccc_cat_id', $_POST['selected_cat'])->first();
            $cat = $ccc->categoria;
            $cir = $ccc->circuit;
            $ins = Inscripcio::where('ins_id', $_POST['ins_id_selected'])->first();
            $ins->ins_retirat = 0;
            $ins->save();
            $inscripcions = Inscripcio::where('ins_ccc_id', $ccc->ccc_id)->get();
        } elseif (isset($_POST['f_recep_no'])) {
            $ccc = Circuit_categoria::where('ccc_cir_id', $_POST['selected_cir'])->where('ccc_cat_id', $_POST['selected_cat'])->first();
            $cat = $ccc->categoria;
            $cir = $ccc->circuit;
            $ins = Inscripcio::where('ins_id', $_POST['ins_id_selected'])->first();
            $ins->ins_retirat = 1;
            $ins->save();
            $inscripcions = Inscripcio::where('ins_ccc_id', $ccc->ccc_id)->get();
        }

        return view('asignarparticipant', [
            'data' => [
                'cursa' => $c,
                'cats' => $cats,
                'inscripcions' => $inscripcions,
                'selected' => [
                    'cat' => $cat,
                    'cir' => $cir,
                ],
            ],
            'errors' => $errors
        ]);
    }

    public function creaciocurses(Request $request)
    {
        $ok = true;
        $usu = Session::get('usu');
        if ($usu == null) {
            return redirect()->route('login');
        }
        if (!$usu->usr_admin) {
            return redirect()->route('login');
        }  
        //Array de errors
        $errors = array(
            'e_nom' => '',
            'e_data_inici' => '',
            'e_data_fi' => '',
            'e_lloc' => '',
            'e_esport' => '',
            'e_descripcio' => '',
            'e_limit' => '',
            'e_foto' => '',
            'e_web' => '',
            'e_circuit' => ''
        );
        //Array ultims camps
        $ultims_camps = array(
            'l_nom' => '',
            'l_data_inici' => '',
            'l_data_fi' => '',
            'l_lloc' => '',
            'l_esport' => '',
            'l_descripccio' => '',
            'l_limit' => '',
            'l_foto' => '',
            'l_web' => '',
            'circuits' => array(
                array(
                    "cc_dist" => '',
                    "cc_nom" => '',
                    "cc_preu" => '',
                    "cc_temps" => '',
                    "cc_punt_k" => array('')
                )
            )
        );
        //Tractament del post
        if (isset($_POST["c_crear"])) {
            //Cridar funccio validar
            $array = $this->validar($ok, $errors, $ultims_camps, $request);
            $ok = $array[0];
            $errors = $array[1];
            $ultims_camps = $array[2];
            $dades = $array[3];

            if ($ok) {

                // Inserta cursa
                $cursa = new Cursa();
                $cursa->cur_nom = $dades[0];
                $cursa->cur_data_inici = $dades[1];
                $cursa->cur_data_fi = $dades[2];
                $cursa->cur_lloc = $dades[3];
                $cursa->cur_esp_id = $dades[4]->esp_id;
                $cursa->cur_est_id = $dades[5]->est_id;
                $cursa->cur_desc = $dades[6];
                $cursa->cur_limit_inscr = $dades[7];
                $cursa->cur_foto = $dades[8]; 
                $cursa->cur_web = $dades[9];
                try {
                    $cursa->save();
                } catch (QueryException $es) {
                    return $es->getMessage();
                }

                foreach ($dades[10] as $key => $cir) {
                    $circuit = new Circuit();
                    $circuit->cir_num = $key;
                    $circuit->cir_cur_id = $cursa->cur_id;
                    $circuit->cir_distancia = $cir['cc_dist'];
                    $circuit->cir_nom = $cir['cc_nom'];
                    $circuit->cir_preu = $cir['cc_preu'];
                    $circuit->cir_temps_estimat = $cir['cc_temps'] ?? '';
                    try {
                        $circuit->save();
                    } catch (QueryException $es) {
                        return $es->getMessage();
                    }

                    foreach ($cir['cc_punt_k'] as $key => $chk) {
                        $check = new Checkpoint();
                        $check->chk_cir_id = $circuit->cir_id;
                        $check->chk_pk = $chk;
                        try {
                            $check->save();
                        } catch (QueryException $es) {
                            return $es->getMessage();
                        }
                    } 
                }

                $ultims_camps["l_nom"] = '';
                $ultims_camps["l_data_inici"] = '';
                $ultims_camps["l_data_fi"] = '';
                $ultims_camps["l_lloc"] = '';
                $ultims_camps["l_esport"] = '';
                $ultims_camps["l_descripccio"] = '';
                $ultims_camps["l_limit"] = '';
                $ultims_camps["l_web"] = '';
                $ultims_camps["circuits"] = array(
                    array(
                        "cc_dist" => '',
                        "cc_nom" => '',
                        "cc_preu" => '',
                        "cc_temps" => '',
                        "cc_punt_k" => array('')
                    )
                );
            }
        } else {
            $ok = false;
        }
        //Carregar els esports per la view
        $esports = Esport::all();
        //return a la view amb la variable esports, errors i ultims camps
        return view('creaciocurses', [
            'esports' => $esports,
            'errors' => $errors,
            'ultims_camps' => $ultims_camps,
            'ok' => $ok
        ]);
    }
    
    private static function eliminaCurses($curses_id)
    {
        foreach ($curses_id as $cur_id) {

            $cur = Cursa::where('cur_id',$cur_id)->first();

            if (is_null($cur) || $cur->cur_est_id != ESTAT_PREPARACIO)
                break;

            $incripcions = Inscripcio::
                join('circuits_categories', 'inscripcions.ins_ccc_id', '=', 'circuits_categories.ccc_id')->
                join('circuits', 'circuits_categories.ccc_cir_id', '=', 'circuits.cir_id')->
                where('circuits.cir_cur_id',$cur_id)->
                get();
        
            $circiuts_categories = Circuit_categoria::
                join('circuits', 'circuits_categories.ccc_cir_id', '=', 'circuits.cir_id')->
                where('circuits.cir_cur_id',$cur_id)->
                get();
        
            $circuits = Circuit::
                where('cir_cur_id',$cur_id)->
                get();

            foreach ($incripcions as $ins)
                $ins->delete();

            foreach ($circiuts_categories as $ccc)
                $ccc->delete();

            foreach ($circuits as $cir) {
                $chks = Checkpoint::where('chk_cir_id',$cir->cir_id)->get();
                foreach ($chks as $chk) {
                    $chk->delete();
                }
                $cir->delete();
            }

            if (!is_null($cur))
                $cur->delete();
        }
    }

    public function filtrecurses(Request $request)
    {
        $ok = true;
        $usu = Session::get('usu');
        if($usu == null){
            return redirect()->route('/');
        }
        if(!$usu->usr_admin){
            return redirect()->route('/');
        }       
        //Eliminar Curses seleccionades
        if(isset($request->f_elimina)){
            if (isset($request->e_ck) && count($request->e_ck) >= 1) {
                self::eliminaCurses($request->e_ck);
            }
        }
        //Obrir inscripció
        if(isset($_POST["f_oberta"])){
            $cursa = Cursa::where('cur_id', $_POST["up_cur_id"])->first();
            $cursa->cur_est_id = ESTAT_OBERTA;
            $cursa->save();
        }
        //Cancel·lar cursa
        if(isset($_POST["f_cancelada"])){
            $cursa = Cursa::where('cur_id', $_POST["up_cur_id"])->first();
            $cursa->cur_est_id = ESTAT_CANCELADA;
            $cursa->save();
        }
        //Inscripció Tancada
        if(isset($_POST["f_tancada"])){
            $cursa = Cursa::where('cur_id', $_POST["up_cur_id"])->first();
            $cursa->cur_est_id = ESTAT_TANCADA;
            $cursa->save();

            $ins_cur = Inscripcio::whereIn('ins_ccc_id', (function ($query) use ($cursa) {
                $query->from('circuits_categories')
                    ->select('ccc_id')
                    ->whereIn('ccc_cir_id', (function ($query) use ($cursa) {
                        $query->from('circuits')
                            ->select('cir_id')
                            ->where('cir_cur_id', $cursa->cur_id);
                    }));
            }))->get();

            foreach ($ins_cur as $key => $i) {
                $i->ins_dorsal = 500 + $key;
                $i->ins_bea_id = $i->ins_id;
                $i->save();
            }
        }
        //En Curs
        if(isset($_POST["f_iniciar"])){
            $cursa = Cursa::where('cur_id', $_POST["up_cur_id"])->first();
            $cursa->cur_est_id = 4;
            $cursa->save();
        }
        //Array amb els ultims camps del filtre
        $last = array(
            'l_nom_lloc' => '',
            'l_data_inici' => '',
            'l_estat' => ''
        );
        //Carregar els estats per la view
        $estats = Estat_cursa::all();
        $est_names = array(
            '-1' => '',
        );
        foreach ($estats as $key => $e) {
            $est_names[$e->est_id] = $e->est_nom;
        }
        //Mostrar totes les curses per defecte
        $curses = Cursa::orderBy('cur_data_inici','ASC')->get();
        //Tractament del post
        $error = '';
        if(isset($_POST["f_cercar"]))
        {
            //Validar el nom
            $nom = $_POST["f_nom_lloc"];
            $last["l_nom_lloc"] = $nom;
            if(strlen($nom) > 50 || strlen($nom) < 0)
            {
                $error = 'La mida del nom no es correcte';
                $ok = false;
            }
            //Aplicar filtre
            $query = Cursa::query();
            $last["l_data_inici"] = $_POST['f_data_inici'];
            if ($_POST['f_data_inici'] != '') {
                $query->whereDate('cur_data_inici', '>=', $_POST['f_data_inici']);
            }
            $last["l_estat"] = $_POST['f_estat'];
            if ($_POST['f_estat'] != '-1') {
                $query->where('cur_est_id', $_POST['f_estat']);
            }
            if($_POST["f_nom_lloc"] != ''){
                $query->where('cur_nom', 'like', '%'.$_POST['f_nom_lloc'].'%')->orWhere('cur_lloc', 'like', '%'.$_POST['f_nom_lloc'].'%');
            }
            if($ok){
                $curses = $query->orderBy('cur_data_inici','ASC')->get();
            }
        }
        //Return a la view
        return view('filtrecurses', [
            'estats' => $est_names,
            'curses' => $curses,
            'error' => $error,
            'last' => $last,
            'usu' => $usu
        ]);
    }

    public function updatecurses(Request $request, $id)
    {
        $ok = true;
        //Array de errors
        $errors = array(
            'e_nom' => '',
            'e_data_inici' => '',
            'e_data_fi' => '',
            'e_lloc' => '',
            'e_esport' => '',
            'e_estat' => '',
            'e_descripcio' => '',
            'e_limit' => '',
            'e_foto' => '',
            'e_web' => '',
            'e_circuit' => 'a'
        );
        //Array ultims camps
        $ultims_camps = array(
            'l_nom' => '',
            'l_data_inici' => '',
            'l_data_fi' => '',
            'l_lloc' => '',
            'l_esport' => '',
            'l_descripccio' => '',
            'l_limit' => '',
            'l_foto' => '',
            'l_web' => ''
        );
        //Agafar la cursa per l'id
        $cursa = Cursa::where('cur_id', $id)->first();
        if($cursa == null){
            return redirect()->route('filtrecurses');
        }
        //Carregar els esports per la view
        $esports = Esport::all();
        $esp_names = array();
        foreach ($esports as $key => $e) {
            $esp_names[$e->esp_id] = $e->esp_nom;
        }
        //Carregar els estats per la view
        $estats = Estat_cursa::all();
        $est_names = array();
        foreach ($estats as $key => $e) {
            $est_names[$e->est_id] = $e->est_nom;
        }

        if (isset($_POST["c_update"])) {
            //Cridar funccio validar
            $array = $this->validar($ok, $errors, $ultims_camps, $request);
            $ok = $array[0];
            $errors = $array[1];
            $ultims_camps = $array[2];
            $dades = $array[3];

            if($ok)
            {
                $cursa->cur_nom = $dades[0];
                $cursa->cur_data_inici = $dades[1];
                $cursa->cur_data_fi = $dades[2];
                $cursa->cur_lloc = $dades[3];
                $cursa->cur_esp_id = $dades[4]->esp_id;
                $cursa->cur_est_id = $dades[5]->est_id;
                $cursa->cur_desc = $dades[6];
                $cursa->cur_limit_inscr = $dades[7];
                $cursa->cur_foto = $dades[8]; 
                $cursa->cur_web = $dades[9];
                try{
                    $cursa->save();
                }catch(QueryException $es){
                    return $es->getMessage();
                }
                return redirect()->route('filtrecurses');
            }
        }
        
        return view('updatecurses', [
            'cursa' => $cursa,
            'esports' => $esp_names,
            'estats' => $est_names,
            'errors' => $errors
        ]);
    }

    public function veurecurses($id)
    {
        //Agafar la cursa per l'id
        $cursa = Cursa::where('cur_id', $id)->first();
        if($cursa == null){
            return redirect()->route('filtrecurses');
        }

        return view('veurecurses', [
            'cursa' => $cursa
        ]);
    }

    public function login()
    {
        if(isset($_POST["e_login"])){
            $usu = Usuari::where('usr_login','like',$_POST['c_login'])->where('usr_password', 'like', $_POST['c_password'])->first();
            if($usu != null){
                Session::put('usu', $usu);
                
                if($usu->usr_admin){
                    return redirect()->route('filtrecurses');
                }
                return redirect()->route('filtrecursescorredors');
            }
        }

        return view('login');
    }

    public function logeout()
    {
        session()->forget('usu');
        session()->flush();

        return redirect()->route('filtrecursescorredors');
    }

    public function filtrecursescorredors()
    {
        $ok = true;

        //Agafar la session
        $usu = Session::get('usu');

        //Mostrar curses obertes per defecte
        $curses = Cursa::where('cur_est_id', '!=', ESTAT_PREPARACIO)->get();
     
        $curses_obertes = array();
        $altres_curses = array();
        foreach ($curses as $key => $c) {
            if ($c->cur_est_id == ESTAT_OBERTA) {
                $curses_obertes[] = $c;
            } else {
                $altres_curses[] = $c;
            }
        }

        //Array amb els ultims camps del filtre
        $last = array(
            'l_nom' => '',
            'l_data_inici' => '',
            'l_esport' => '',
            'l_estat' => ''
        );

        //Carregar els esports per la view
        $esports = Esport::all();
        $esp_names = array('-1' => '');
        foreach ($esports as $key => $e)
            $esp_names[$e->esp_id] = $e->esp_nom;

        //Carregar els estats per la view
        $estats = Estat_cursa::all();
        $est_names = array('-1' => '');
        foreach ($estats as $key => $e) {
            if ($e->est_id != ESTAT_PREPARACIO) {
                $est_names[$e->est_id] = $e->est_nom;
            }
        }
            
        //Post
        $error = '';
        $titol = "Curses obertes";
        if (isset($_POST["f_cercar"])) {
            //Validar el nom
            $nom = $_POST["f_nom"];
            $last["l_nom"] = $nom;
            if(strlen($nom) > 50 || strlen($nom) < 0) {
                $error = 'La mida del nom no es correcte';
                $ok = false;
            }
            
            //Aplicar filtre
            $query = Cursa::query();
            $query->where('cur_nom', 'like', '%'.$_POST['f_nom'].'%')->where('cur_est_id','!=',1);
            $last["l_data_inici"] = $_POST['f_data_inici'];

            if ($_POST['f_data_inici'] != '')
                $query->whereDate('cur_data_inici', '>=', $_POST['f_data_inici']);
            
            $last["l_esport"] = $_POST['f_esport'];
            if ($_POST['f_esport'] != '-1')
                $query->where('cur_esp_id', $_POST['f_esport']);
            
            $last["l_estat"] = $_POST['f_estat'];
            if ($_POST['f_estat'] != '-1')
                $query->where('cur_est_id', $_POST['f_estat']);
            
            if ($ok) {
                $curses_obertes = $query->orderBy('cur_data_inici','DESC')->get();
                $titol = "Curses filtrades";
            }
        }

        $curses_totals = array(
            [
                'titol' => $titol,
                'curses' => $curses_obertes
            ]
        );

        if (!isset($_POST["f_cercar"])) {
            $altres_titol = "altres curses";
            if (count($altres_curses) == 0) 
                $altres_titol = "No s'han trobat més curses";
            
            $curses_totals[] = array(
                'titol' => $altres_titol,
                'curses' => $altres_curses
            );
        }

        return view('filtrecursescorredors', [
            'esports' => $esp_names,
            'estats' => $est_names,
            'curses_totals' => $curses_totals,
            'usu'   => $usu,
            'last'  => $last,
            'error' => $error
        ]);
    }

    public function veurecursesadmin($id)
    {
        $usu = Session::get('usu');
        if ($usu == null || !$usu->usr_admin) {
            return redirect()->route('/');
        }
        
        //Agafar la cursa per l'id
        $cursa = Cursa::where('cur_id', $id)->first();
        if($cursa == null){
            return redirect()->route('filtrecurses');
        }

        $n_ins = Inscripcio::whereIn('ins_ccc_id', (function ($query) use ($cursa) {
            $query->from('circuits_categories')
                ->select('ccc_id')
                ->whereIn('ccc_cir_id',(function ($query) use ($cursa) {
                    $query->from('circuits')
                        ->select('cir_id')
                        ->where('cir_cur_id', $cursa->cur_id);
                }));
        }))->count();

        $dist = Circuit::where('cir_cur_id', $cursa->cur_id)->get();
        $n_cir = count($dist); 

        return view('veurecursesadmin', [
            'cursa' => $cursa,
            'nins' => $n_ins,
            'n_cir' => $n_cir,
            'dist' => $dist
        ]);
    }
}
