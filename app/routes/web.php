<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscripcioController;
use App\Http\Controllers\CreaciocursaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::match(['post', 'get'], '/',                      [CreaciocursaController::class, 'filtrecursescorredors'])   -> name('filtrecurses');
Route::match(['post', 'get'], '/filtrecurses',          [CreaciocursaController::class, 'filtrecurses'])            -> name('filtrecurses');
Route::match(['post', 'get'], '/creaciocurses',         [CreaciocursaController::class, 'creaciocurses'])           -> name('creaciocurses');
Route::match(['post', 'get'], '/updatecurses/{id}',     [CreaciocursaController::class, 'updatecurses'])            -> name('updatecurses');
Route::match(['post', 'get'], '/veurecurses/{id}',      [CreaciocursaController::class, 'veurecurses'])             -> name('veurecurses');
Route::match(['post', 'get'], '/inscriure/{id}',        [InscripcioController::class,   'inscriure'])               -> name('inscriure');
Route::match(['post', 'get'], '/login',                 [CreaciocursaController::class, 'login'])                   -> name('login');
Route::match(['post', 'get'], '/logeout',               [CreaciocursaController::class, 'logeout'])                 -> name('logeout');
Route::match(['post', 'get'], '/filtrecursescorredors', [CreaciocursaController::class, 'filtrecursescorredors'])   -> name('filtrecursescorredors');
Route::match(['post', 'get'], '/veurecursesadmin/{id}', [CreaciocursaController::class, 'veurecursesadmin'])        -> name('veurecursesadmin');
Route::match(['post', 'get'], '/resultats/{id}',        [InscripcioController::class,   'veureresultats'])          -> name('veureresultats');