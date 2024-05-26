<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebServiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Rutas de todos los Web Services
Route::get('getCurses/{id?}',   [WebServiceController::class, 'getCurses']);
Route::get('getCircuits/{id?}', [WebServiceController::class, 'getCircuits']);
Route::get('inscriure/{json?}', [WebServiceController::class, 'inscriure']);
Route::get('getResultats/{json?}', [WebServiceController::class, 'getResultats']);
Route::get('participantCheckpoint/{json?}',  [WebServiceController::class, 'participantCheckpoint']);
Route::post('getCircuitsCursaCategoria',     [WebServiceController::class, 'getCircuitsCursaCategoria']);
Route::get('/getesportcategories/{id}',      [WebServiceController::class, 'getesportcategories']);