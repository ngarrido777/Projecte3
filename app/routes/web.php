<?php

use Illuminate\Support\Facades\Route;
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

Route::match(['post', 'get'], '/', [CreaciocursaController::class, 'filtrecurses']) -> name('filtrecurses');
Route::match(['post', 'get'], '/creaciocurses', [CreaciocursaController::class, 'creaciocurses']) -> name('creaciocurses');
Route::post('/updatecurses', [CreaciocursaController::class, 'updatecurses']) -> name('updatecurses');