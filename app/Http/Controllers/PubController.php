<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserEditRequest;
use Illuminate\Support\Facades\DB;

class PubController extends Controller
{
    public function createPub(){
        $queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();
        return view('pub.create', compact('queryNotifications'));
    }
}
