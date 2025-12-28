<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\KategorijaController;
use App\Http\Controllers\NovcanikController;
use App\Http\Controllers\TransakcijaController;
use App\Http\Controllers\TransferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::middleware('auth:sanctum')->group(function(){
    
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/me',[AuthController::class,'me']);

    Route::get('/transakcije/moje',[TransakcijaController::class,'moje']);
    Route::get('/transakcije/moje-prilivi',[TransakcijaController::class,'mojiPrilivi']);
    Route::get('/transakcije/moje-odlivi',[TransakcijaController::class,'mojiOdlivi']);
    Route::get('/transakcije/moje-prilivi-pag',[TransakcijaController::class,'mojiPriliviPaginated']);
    Route::get('/transakcije/moje-odlivi-pag-fil',[TransakcijaController::class,'mojiOdliviPaginatedFiltered']);
});

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

//
Route::post('/password/forgot',[ForgotPasswordController::class,'sendResetLink']);
Route::post('/password/reset',[ForgotPasswordController::class,'resetPassword']);

//
Route::get('/email/verify/{id}',[AuthController::class,'verifyEmail'])
->name('verification.verify');
//


Route::get('/novcanici',[NovcanikController::class,'index']);

Route::get('/novcanici/{id}',[NovcanikController::class,'show']);

Route::post('/novcanici',[NovcanikController::class,'store']);

Route::delete('/novcanici/{id}',[NovcanikController::class,'destroy']);

Route::put('/novcanici/{id}',[NovcanikController::class,'update']);




Route::get('/kategorije',[KategorijaController::class,'index']);

Route::get('/kategorije/{id}',[KategorijaController::class,'show']);

Route::post('/kategorije',[KategorijaController::class,'store']);

Route::delete('/kategorije/{id}',[KategorijaController::class,'destroy']);

Route::put('/kategorije/{id}',[KategorijaController::class,'update']);





Route::get('/transakcije',[TransakcijaController::class,'index']);

Route::get('/transakcije/{id}',[TransakcijaController::class,'show']);

Route::post('/transakcije',[TransakcijaController::class,'store']);

Route::delete('/transakcije/{id}',[TransakcijaController::class,'destroy']);

Route::put('/transakcije/{id}',[TransakcijaController::class,'update']);



Route::resource('/transferi',TransferController::class);
//^ova linija koda pokriva sve crud operacije iz controller-a Transfer-a