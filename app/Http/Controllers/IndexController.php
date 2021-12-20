<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Publicacao;
use App\Models\Comments;

class IndexController extends Controller
{
    public function index(){
        $pubs = Publicacao::orderBy('created_at','DESC')->get();
        
        
        $publicacoes = [];
        foreach($pubs as $pub){
            $comment = Comments::where('publicacao_id','=',$pub->id)->get();
            $publicacao = [
                'infoPub' => Publicacao::where('id','=',$pub->id)->get()[0],
                'infoComent' => Comments::where('publicacao_id','=',$pub->id)->get(),
                'infoLike' => DB::table('likes')->where('pubId','=',$pub->id)->get()
            ];
            //dd($publicacao);
            array_push($publicacoes, $publicacao);
            
        }
        //$queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->get();;
       
        return view('welcome',['queryNotifications'=>[],'pubs'=>$publicacoes]);
    }
    
}
