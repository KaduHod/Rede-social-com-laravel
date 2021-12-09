<?php

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
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;

//INDEX
    Route::get('/', [IndexController::class,'index']);

//LOGIN
    Route::get('/logar', [UserController::class,'telaDelogin']);
    Route::get('/registrar', [UserController::class,'telaDeRegistro']);
    Route::post('/login', [UserController::class,'liberarUser']);
    Route::get('/dashboard', [UserController::class,'dashboard'])->middleware('auth');
    Route::post('/reg', [UserController::class,'store']);
    Route::post('/logout', [UserController::class,'logout']);

//Admin
    Route::get('/tabelaDeUsuarios', [UserController::class,'tabelaDeUsuarios'])->middleware('auth');
    Route::get('/tabelaDeUsuarios/editUser/{id}', [UserController::class,'editUser'])->middleware('auth');
    Route::post('/tabelaDeUsuarios/edit', [UserController::class,'edit'])->middleware('auth');
    Route::get('/tabelaDeUsuarios/exclude/{id}', [UserController::class,'destroy'])->middleware('auth');

//SEARCH DE PERFIL
    Route::get('/searchPerfil',[UserController::class,'search'])->middleware('auth');


