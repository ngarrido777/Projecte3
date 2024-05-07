<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Esport;
use App\Models\Estat_cursa;

class CreaciocursaController extends Controller
{
    public function creaciocurses()
    {
        //Tractament del post
        if(isset($_POST["c_crear"]))
        {
            //Validar les dades de la cursa
            //Validar nom
            $nom = $_POST["c_nom"];
            if(strlen($nom) > 50 || strlen($nom) <= 0)
            {
                //Error
            }
            //Validar data inici
            $data_inici = $_POST["c_data_inici"];
            //TO DO validar c_data_inici
            //Validar data fi
            $data_fi = $_POST["c_data_fi"];
            //TO DO validar c_data_fi
            //Validar lloc
            $lloc = $_POST["c_lloc"];
            if(strlen($lloc) > 20 || strlen($lloc) <= 0)
            {
                //Error
            }
            //Validar esport
            $id_esport = $_POST["c_esport"];
            //Crear l'estat de la cursa
            //Validar descripccio
            $descripccio = $_POST["c_descripccio"];
            if(strlen($descripccio) > 1000 || strlen($descripccio) <= 0)
            {
                //Error
            }
            //Validar limit inscrits
            $limit = $_POST["c_limit"];
            if(is_numeric($limit))
            {
                //Error
            }
            //TO DO tractar i validar imatge :(
            //Validar web
            $web = $_POST["c_web"];
            if(strlen($web) > 200 || strlen($web) <= 0)
            {
                //Error
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
        ]);
    }
}
