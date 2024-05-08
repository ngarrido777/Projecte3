<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Esport;
use App\Models\Estat_cursa;
use App\Models\Cursa;

class CreaciocursaController extends Controller
{
    public function creaciocurses(Request $request)
    {
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
            'l_descripcio' => '',
            'l_limit' => '',
            'l_foto' => '',
            'l_web' => ''
        );
        //Tractament del post
        if(isset($_POST["c_crear"]))
        {
            $ok = true;
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
            if(strlen($descripccio) > 1000 || strlen($descripccio) <= 0)
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
                $foto = base64_encode(file_get_contents($file->getRealPath()));
                $ultims_camps["l_foto"] = $foto;
            }else{
                $errors['e_foto'] = 'Error en carregar la imatge';
                $ok = false;
            }
            //Validar web
            $web = $_POST["c_web"];
            $ultims_camps["l_web"] = $web;
            if(strlen($web) > 200 || strlen($web) <= 0)
            {
                $errors['e_web'] = 'La mida de la web no es correcte';
                $ok = false;
            }

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
                $cursa->save();
            }
        }
        //Carregar els esports per la view
        $esports = Esport::all();
        $esp_names = array();
        foreach ($esports as $key => $e) {
            $esp_names[$e->esp_id] = $e->esp_nom;
        }
        //return a la view amb la variable esports
        return view('creaciocurses', [
            'esports' => $esp_names,
            'errors' => $errors,
            'ultims_camps' => $ultims_camps
        ]);
    }
}
