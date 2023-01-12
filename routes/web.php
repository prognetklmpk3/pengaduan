<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResponController;
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
Route::get('/',function(){
    return redirect('/pengaduan','/admin');

});

Route::group(['prefix'=>'pengaduan','as'=>'pengaduan.'], function(){
    Route::get('/',[PengaduController::class,'index'])->name('welcome');
    Route::get('/aduan/{id}/check',[PengaduController::class,'checkAduan'])->name('check');
    Route::get('/aduan/{id}',[PengaduController::class,'show'])->name('show');
    Route::post('/respon', [PengaduController::class,'respon'])->name('store');

    // Route::post('/listData',[PengaduController::class,'listData'])->name('listData');

    Route::get('/create',[PengaduController::class,'create'])->name('create');

    Route::get('/thanks/{id}',[PengaduController::class,'thanks'])->name('thanks');


    Route::post('/', [PengaduController::class,'store'])->name('store');
    Route::patch('/{id}', [PengaduController::class,'update'])->name('update');

});

Route::group(['prefix'=>'admin','as'=>'admin.'], function(){
    Route::get('/',[ResponController::class,'index'])->name('index');
    Route::post('/list-aduan',[ResponController::class,'listAduan'])->name('list-aduan');

    Route::get('/aduan/{id}',[ResponController::class,'show'])->name('show');

    Route::post('/respon', [ResponController::class,'store'])->name('store');

    Route::patch('/aduan/{id}/close', [ResponController::class,'close'])->name('close');
});