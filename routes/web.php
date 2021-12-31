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
use App\Http\Controllers\TesteController;
use App\Http\Controllers\ChatController;
use App\Models\User;
use App\Models\Chat;
use App\Models\Message;





Auth::routes();
//INDEX
    Route::get('/', [IndexController::class,'index']);

//SEARCH DE PERFIL
    Route::get('/searchPerfil',[UserController::class,'search'])->middleware('auth');

//LOGIN
    //Route::get('/logar', [UserController::class,'telaDelogin']);
    Route::get('/logar',array('as'=>'login',UserController::class,'telaDelogin'));
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
    //Route::get('/visualizarNotificação/{id}',[UserController::class, 'visualizarNotificação'])->middleware('auth');

// Pub
    Route::get('/createPub',[PubController::class, 'createPub'])->middleware('auth');
    Route::post('/storePub',[PubController::class, 'store'])->middleware('auth');
    Route::get('/editComent/{pubId}/{commentId}',[PubController::class,'destroyComment'])->middleware('auth');
    Route::post('/coment',[PubController::class,'comment'])->middleware('auth');
    Route::get('/like/{pubId}', [PubController::class, 'likePub'])->middleware('auth');
    Route::get('/deslike/{pubId}', [PubController::class, 'deslikePub'])->middleware('auth');
    Route::get('/pub/{pubId}',[PubController::class, 'show']);
    Route::get('/editLayout', [UserController::class, 'customizeLayout'])->middleware('auth');
    Route::post('/editLayoutStore', [UserController::class, 'storeLayout'])->middleware('auth');


// chat
    Route::get('/chat',[ChatController::class,'index'])->middleware('auth');
    Route::post('/chat/postMassage',[ChatController::class, 'postMassage'])->middleware('auth');
    Route::post('/chat/createChat',[ChatController::class,'createChat'])->middleware('auth');


    //teste
    Route::get('/teste',function(){
        $user1 = App\Models\User::where('id','=',76)->get()[0];//carlos
        $user2 = App\Models\User::where('id','=',77)->get()[0];//natasha
        $user3 = App\Models\User::where('id','=',84)->get()[0];//luan
        $user4 = App\Models\User::where('id','=',85)->get()[0];//erick 

        $arrUsers = [$user1,$user2,$user3,$user4];


        /*  $chat1 = Chat::create([]);

        $chat1->users()->attach($user1);
        $chat1->users()->attach($user2);

        Message::create([
            'user_id'=>$user2->id,
            'chat_id'=>$chat1->id,
            'message'=>'oi carlos'
        ]);
        Message::create([
            'user_id'=>$user1->id,
            'chat_id'=>$chat1->id,
            'message'=>'oi natasha'
        ]);



        $chat2 = Chat::create([]);

        $chat2->users()->attach($user1);
        $chat2->users()->attach($user3);

        Message::create([
            'user_id'=>$user1->id,
            'chat_id'=>$chat2->id,
            'message'=>'dae luan'
        ]);
        Message::create([
            'user_id'=>$user3->id,
            'chat_id'=>$chat2->id,
            'message'=>'dea pia'
        ]);



        $chat3 = Chat::create([]);


        $chat3->users()->attach($user1);
        $chat3->users()->attach($user4);

        Message::create([
            'user_id'=>$user1->id,
            'chat_id'=>$chat3->id,
            'message'=>'dae erick'
        ]);
        Message::create([
            'user_id'=>$user4->id,
            'chat_id'=>$chat3->id,
            'message'=>'dae carlos'
        ]);  */        

    });
    





