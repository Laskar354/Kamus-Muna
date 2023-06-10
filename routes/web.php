<?php

use App\Http\Controllers\DashboardKamusController;
use App\Http\Controllers\KamusController;
use App\Http\Controllers\loginAdminController;
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
    return view('translate');
});

Route::get('/translate', function(){
    return view('translate');
});

Route::get('/tentang', function(){
    return view('about');
});

Route::get('prosesKata', [KamusController::class, "prosesKataIndo"]);
Route::get('prosesKalimatIndo', [KamusController::class, "prosesKalimatIndo"]);


// Login dan logout Admin
Route::get('/translate/loginAdmin', [LoginAdminController::class, "index"])->middleware("guest");
Route::post('/translate/loginAdmin', [LoginAdminController::class, "authenticate"])->middleware("guest");
Route::post('/translate/logoutAdmin', [LoginAdminController::class, "logout"]);


//Dashbord Kamus
Route::resource('/dashboardKamus', DashboardKamusController::class);

Route::put("/dashboardKamus", "DashboardKamusController@Store")->name("kamus.store")->middleware("auth");
Route::delete("/dashboardKamus/{id}", "DashboardKamusController@Delete")->name("kamus.delete")->middleware("auth");
Route::get("/dashboardKamus/{id}/edit", "DashboardKamusController@Edit")->name("kamus.edit")->middleware("auth");
Route::post("/dashboardKamus/{id}", "DashboardKamusController@Update")->name("kamus.update")->middleware("auth");