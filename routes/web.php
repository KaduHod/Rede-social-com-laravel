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
use App\Http\Controllers\PubController;



//INDEX
    Route::get('/', [IndexController::class,'index']);

//SEARCH DE PERFIL
    Route::get('/searchPerfil',[UserController::class,'search'])->middleware('auth');

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

//USER
    Route::get('/profile',[UserController::class,'profile'])->middleware('auth');
    Route::get('/editUser/{id}', [UserController::class,'editUser'])->middleware('auth');
    

//View Profile
    Route::get('/outsiderProfile/{id}',[UserController::class, 'outsiderProfile'])->middleware('auth');
    Route::get('/registerFollow/{outsider}',[UserController::class, 'follow'])->middleware('auth');
    Route::get('/registerUnfollow/{outsider}',[UserController::class, 'unFollow'])->middleware('auth');
    Route::get('/visualizarNotificação/{id}',[UserController::class, 'visualizarNotificação'])->middleware('auth');

// Pub
    Route::get('/createPub',[PubController::class, 'createPub'])->middleware('auth');
    Route::post('/storePub',[PubController::class, 'store'])->middleware('auth');
    Route::post('/comentPub',[PubController::class,'comment'])->middleware('auth');
    Route::post('/coment',[PubController::class,'comment'])->middleware('auth');
    Route::get('/like/{pubId}', [PubController::class, 'likePub'])->middleware('auth');
    Route::get('/deslike/{pubId}', [PubController::class, 'deslikePub'])->middleware('auth');


