<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Chat;
use App\Models\Message;

function pegaUltimaMensagem($arrMSG){
    $msgMaisRecente = $arrMSG[0];
    foreach($arrMSG as $msg){
        if( strtotime($msg->created_at) > strtotime($msgMaisRecente->created_at) ) $msgMaisRecente = $msg;
    }
    return $msgMaisRecente;
}

class ChatController extends Controller
{

    public function index(){
        
        $chatPadrao = [
            'guestUser'=> '',
            'mensagens'=>'',
            'chat'=>''
        ];
        $chats = Auth::user()->chats;

        
        if(count($chats)>0){
                $mensagens_dos_chats = [];

            foreach($chats as $chat){
                foreach($chat->messages as $msg){
                    array_push($mensagens_dos_chats,$msg);
                }
            } 
            
            $msgMaisRecente = pegaUltimaMensagem($mensagens_dos_chats);
            
            $guest_user = '';

            $chat_mais_recente = Chat::where('id','=',$msgMaisRecente->chat_id)->get()[0];

            foreach($chat_mais_recente->users as $user){
                if($user->id != Auth::user()->id) $guest_user = $user;
            }

            $chatPadrao['mensagens'] = $chat_mais_recente->messages;
            $chatPadrao['guestUser'] = $guest_user;
            $chatPadrao['chat'] = $chat_mais_recente->id; 

            return view('chat.index', compact('chats','chatPadrao'));
            
        }
            
    
    
        
        return view('chat.index2', compact('chats','chatPadrao'));
    }
    public function postMassage(Request $request){
        Message::create([
            'user_id'=>Auth::user()->id,
            'chat_id'=>$request->chat_id,
            'message'=>$request->sandMassage
        ]);
        return redirect('/chat'); 
        
    }
    public function createChat(Request $request){
        $newChat = Chat::create([]);
        $guestUser = User::findOrFail($request->guest_id);

        $newChat->users()->attach(Auth::user());
        $newChat->users()->attach($guestUser);

        Message::create([
            'user_id'=>Auth::user()->id,
            'chat_id'=>$newChat->id,
            'message'=>$request->sandMassage
        ]);
        

        return back(); 
    }
}
