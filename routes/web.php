<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PengaduController;

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


Route::group(['prefix'=>'pengaduan','as'=>'pengaduan.'], function(){
    Route::get('/',[PengaduController::class,'index'])->name('welcome');
    Route::get('/aduan/{id}/check',[PengaduController::class,'checkAduan'])->name('check');
    Route::get('/aduan/{id}',[PengaduController::class,'show'])->name('show');
    Route::post('/respon',[PengaduController::class,'respon'])->name('store');

    // Route::post('/listData',[PengaduController::class,'listData'])->name('listData');

    Route::get('/create',[PengaduController::class,'create'])->name('create');

    Route::get('/thanks/{id}',[PengaduController::class,'thanks'])->name('thanks');


    Route::post('/', [PengaduController::class,'store'])->name('store');
    Route::patch('/{id}', [PengaduController::class,'update'])->name('update');

});

Route::get('/',[PegawaiController::class,'formLogin'])->name('form-login');
Route::post('login',[PegawaiController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:pegawai'], function(){
    Route::post('logout',[PegawaiController::class, 'logout'])->name('logout');
});

Route::group(['prefix'=>'pegawai','as'=>'pegawai.', 'middleware' => 'auth:pegawai'], function(){
    Route::get('/list', [PegawaiController::class,'index'])->name('index');
    Route::post('/list-aduan',[PegawaiController::class,'listAduan'])->name('list-aduan');

    Route::get('/aduan/{id}',[PegawaiController::class,'show'])->name('show');

    Route::post('/respon',[PegawaiController::class,'store'])->name('store');

    Route::patch('/aduan/{id}/close',[PegawaiController::class,'close'])->name('close');
});