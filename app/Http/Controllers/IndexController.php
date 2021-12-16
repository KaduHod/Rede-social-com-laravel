<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Publicacao;

class IndexController extends Controller
{
    public function index(){
        //$queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->get();;
        $pubs = Publicacao::all();
        return view('welcome',['queryNotifications'=>[],'pubs'=>$pubs]);
    }
    
}
