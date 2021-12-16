<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserEditRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Publicacao;

class PubController extends Controller
{
    public function createPub(){
        $users = User::all();

        $queryIdFollows = DB::table('user_follows')->select('follows_id')->where('user_id','=',Auth::user()->id)->get();// id dos usuarios seguidos pelo usuario logado
        
        $followsid = []; // array com os id dos usuarios seguidos pelo usuario logado
        foreach($queryIdFollows as $follows){
            array_push($followsid, $follows->follows_id);
        }
        
        $followsUsers = DB::table('users')->whereIn('id',$followsid)->get();// usuarios seguidos pelo usuario logado
       


        $queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();
        $pubs = Publicacao::all();
        
        return view('pub.create', compact('queryNotifications','followsUsers'));
    }

    public function store(Request $request){
        dd($request->all());
    }
}
