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
    Route::post('/status',[PengaduController::class,'status'])->name('status');

    // Route::post('/listData',[PengaduController::class,'listData'])->name('listData');

    Route::get('/create',[PengaduController::class,'create'])->name('create');

    Route::get('/thanks/{id}',[PengaduController::class,'thanks'])->name('thanks');

    Route::get('/{id}/edit',[PengaduController::class,'edit'])->name('edit');
    Route::delete('/{id}',[PengaduController::class,'deleteData'])->name('delete');

    Route::post('/', [PengaduController::class,'store'])->name('store');
    Route::patch('/{id}', [PengaduController::class,'update'])->name('update');

});

Route::group(['prefix'=>'admin','as'=>'admin.'], function(){
    Route::get('/',[ResponController::class,'index'])->name('index');
    Route::post('/list-aduan',[ResponController::class,'listAduan'])->name('list-aduan');

    Route::get('/aduan/{id}',[ResponController::class,'show'])->name('show');

    Route::post('/respon', [ResponController::class,'store'])->name('store');

    Route::get('/aduan/{id}/edit', [ResponController::class,'update'])->name('update');



});