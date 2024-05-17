<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Cursa;
use App\Models\Categoria;
use App\Models\Circuit;
use App\Models\Circuit_Categoria;
use \Illuminate\Database\QueryException;

    // Errores
    const MSG_INF = 'msg_inf';
    const MSG_ADV = 'msg_adv';
    const MSG_ERR = 'msg_err';
class InscripcioController extends Controller
{
    private function inscriureView($cursa,$cats,$code = null,$mensaje = null) {
        return view('inscriure', [
            'data' => [
                'cursa' => $cursa,
                'cats' => $cats
            ],
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

        $categories = Categoria::where('cat_esp_id',$c[0]->cur_esp_id)->get();

        if (isset($_POST['insSubmit'])) {
            // TODO
            $text = "Felicidades!! Te has inscrito a la cursa " . $c[0]->cur_nom;
            return $this->inscriureView($c[0], $categories, MSG_INF, $text);
        }
        
        return $this->inscriureView($c[0], $categories);
    }
}
