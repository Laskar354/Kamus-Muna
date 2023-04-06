<?php

use App\Http\Controllers\KamusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('kamus');
});

Route::get('/translate', function(){
    return view('translate');
});


Route::get('prosesKata', [KamusController::class, "prosesKataIndo"]);

Route::get('prosesKalimatIndo', [KamusController::class, "prosesKalimatIndo"]);
