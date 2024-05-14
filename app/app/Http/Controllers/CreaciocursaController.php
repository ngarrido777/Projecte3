<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Esport;
use App\Models\Estat_cursa;
use App\Models\Cursa;
use \Illuminate\Database\QueryException;

class CreaciocursaController extends Controller
{
    public function validar($ok, $errors, $ultims_camps, $request)
    {
        //Validar les dades de la cursa
        //Validar nom
        $nom = $_POST["c_nom"];
        $ultims_camps["l_nom"] = $nom;
        if(strlen($nom) > 50 || strlen($nom) <= 0)
        {
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
        if (!($data_inici < $data_fi))
        {
            $errors['e_data_fi'] = 'La data de inici ha de ser anterior a la data de fi';
            $ok = false;
        }
        //Validar lloc
        $lloc = $_POST["c_lloc"];
        $ultims_camps["l_lloc"] = $lloc;
        if(strlen($lloc) > 20 || strlen($lloc) <= 0)
        {
            $errors['e_lloc'] = 'La mida del lloc no es correcte';
            $ok = false;
        }
        //Validar esport
        $id_esport = $_POST["c_esport"];
        $ultims_camps["l_esport"] = $id_esport;
        $esport = Esport::where('esp_id', $id_esport)->first();
        //Crear l'estat de la cursa
        $estat = Estat_cursa::where('est_id', 1)->first();
        //Validar descripccio
        $descripccio = $_POST["c_descripccio"];
        $ultims_camps["l_descripccio"] = $descripccio;
        if(strlen($descripccio) > 1000)
        {
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
        //Validar imatge
        if ($request->hasFile('c_foto') && $request->file('c_foto')->isValid()) {
            $file = $request->file('c_foto');
            $size = getimagesize($file);
            //Validar mida de la imatge sense codificar a base64
            if($file->getSize() <= 5000000){
                if($size)
                {
                    $foto = base64_encode(file_get_contents($file->getRealPath()));
                    //$ultims_camps["l_foto"] = $file;
                }else
                {
                    $errors['e_foto'] = 'Error en el format de la imatge';
                    $ok = false;
                }
            }else{
                $errors['e_foto'] = 'Error en la mida de la imatge maxim 5M';
                $ok = false;
            }
        }else{
            $errors['e_foto'] = 'Error en carregar la imatge';
            $ok = false;
        }
        //Validar web
        $web = $_POST["c_web"];
        $ultims_camps["l_web"] = $web;
        if(strlen($web) > 200)
        {
            $errors['e_web'] = 'La mida de la web no es correcte';
            $ok = false;
        }

        return array($ok, $errors, $ultims_camps);
    }

    public function creaciocurses(Request $request)
    {
        $ok = true;
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
            'e_web' => ''
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
        //Tractament del post
        if(isset($_POST["c_crear"]))
        {
            //Cridar funccio validar
            $array = $this->validar($ok, $errors, $ultims_camps, $request);
            $ok = $array[0];
            $errors = $array[1];
            $ultims_camps = $array[2];

            if($ok)
            {
                $cursa = new Cursa();
                $cursa->cur_nom = $nom;
                $cursa->cur_data_inici = $data_inici;
                $cursa->cur_data_fi = $data_fi;
                $cursa->cur_lloc = $lloc;
                $cursa->cur_esp_id = $esport->esp_id;
                $cursa->cur_est_id = $estat->est_id;
                $cursa->cur_desc = $descripccio;
                $cursa->cur_limit_inscr = $limit;
                $cursa->cur_foto = $foto; 
                $cursa->cur_web = $web;
                try{
                    $cursa->save();
                }catch(QueryException $es){
                    return $es->getMessage();
                }

                $ultims_camps["l_nom"] = '';
                $ultims_camps["l_data_inici"] = '';
                $ultims_camps["l_data_fi"] = '';
                $ultims_camps["l_lloc"] = '';
                $ultims_camps["l_esport"] = '';
                $ultims_camps["l_descripccio"] = '';
                $ultims_camps["l_limit"] = '';
                $ultims_camps["l_web"] = '';
            }
        }
        //Carregar els esports per la view
        $esports = Esport::all();
        $esp_names = array();
        foreach ($esports as $key => $e) {
            $esp_names[$e->esp_id] = $e->esp_nom;
        }
        //return a la view amb la variable esports, errors i ultims camps
        return view('creaciocurses', [
            'esports' => $esp_names,
            'errors' => $errors,
            'ultims_camps' => $ultims_camps,
            'ok' => $ok
        ]);
    }

    public function filtrecurses()
    {
        //Array amb els ultims camps del filtre
        $last = array(
            'l_nom' => '',
            'l_data_inici' => '',
            'l_esport' => '',
            'l_estat' => ''
        );
        //Carregar els esports per la view
        $esports = Esport::all();
        $esp_names = array(
            '-1' => '',
        );
        foreach ($esports as $key => $e) {
            $esp_names[$e->esp_id] = $e->esp_nom;
        }
        //Carregar els estats per la view
        $estats = Estat_cursa::all();
        $est_names = array(
            '-1' => '',
        );
        foreach ($estats as $key => $e) {
            $est_names[$e->est_id] = $e->est_nom;
        }
        //Mostrar totes les curses per defecte
        $curses = Cursa::all();
        //Tractament del post
        $error = '';
        if(isset($_POST["f_cercar"]))
        {
            //Validar el nom
            $nom = $_POST["f_nom"];
            $last["l_nom"] = $nom;
            if(strlen($nom) > 50 || strlen($nom) < 0)
            {
                $error = 'La mida del nom no es correcte';

                return view('filtrecurses', [
                    'esports' => $esp_names,
                    'estats' => $est_names,
                    'curses' => $curses,
                    'error' => $error,
                    'last' => $last
                ]);
            }
            //Aplicar filtre
            $query = Cursa::query();
            $query->where('cur_nom', 'like', '%'.$_POST['f_nom'].'%');
            $last["l_data_inici"] = $_POST['f_data_inici'];
            if ($_POST['f_data_inici'] != '') {
                $query->whereDate('cur_data_inici', '=', $_POST['f_data_inici']);
            }
            $last["l_esport"] = $_POST['f_esport'];
            if ($_POST['f_esport'] != '-1') {
                $query->where('cur_esp_id', $_POST['f_esport']);
            }
            $last["l_estat"] = $_POST['f_estat'];
            if ($_POST['f_estat'] != '-1') {
                $query->where('cur_est_id', $_POST['f_estat']);
            }

            $curses = $query->get();
        }
        //Return a la view
        return view('filtrecurses', [
            'esports' => $esp_names,
            'estats' => $est_names,
            'curses' => $curses,
            'error' => $error,
            'last' => $last,
        ]);
    }

    public function updatecurses($id)
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
            'e_web' => ''
        );
        //Agafar la cursa per l'id
        $cursa = Cursa::where('cur_id', $id)->first();
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

        
        
        return view('updatecurses', [
            'cursa' => $cursa,
            'esports' => $esp_names,
            'estats' => $est_names,
            'errors' => $errors
        ]);
    }
}
