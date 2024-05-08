<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Esport;
use App\Models\Estat_cursa;

class CreaciocursaController extends Controller
{
    public function creaciocurses()
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
        //Tractament del post
        if(isset($_POST["c_crear"]))
        {
            //Validar les dades de la cursa
            //Validar nom
            $nom = $_POST["c_nom"];
            if(strlen($nom) > 50 || strlen($nom) <= 0)
            {
                $errors['e_nom'] = 'La mida del nom no es correcte';
            }
            //Validar data inici
            $data_inici = $_POST["c_data_inici"];
            //Validar data fi
            $data_fi = $_POST["c_data_fi"];
            //Validar lloc
            $lloc = $_POST["c_lloc"];
            if(strlen($lloc) > 20 || strlen($lloc) <= 0)
            {
                $errors['e_lloc'] = 'La mida del lloc no es correcte';
            }
            //Validar esport
            $id_esport = $_POST["c_esport"];
            //Crear l'estat de la cursa
            //Validar descripccio
            $descripccio = $_POST["c_descripccio"];
            if(strlen($descripccio) > 1000 || strlen($descripccio) <= 0)
            {
                $errors['e_descripccio'] = 'La mida de la descripccio no es correcte';
            }
            //Validar limit inscrits
            $limit = $_POST["c_limit"];
            if(!is_numeric($limit))
            {
                $errors['e_limit'] = 'El limit ha de ser numeric';
            }
            //TO DO tractar i validar imatge :(
            //Validar web
            $web = $_POST["c_web"];
            if(strlen($web) > 200 || strlen($web) <= 0)
            {
                $errors['e_web'] = 'La mida de la web no es correcte';
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
            'errors' => $errors
        ]);
    }
}
