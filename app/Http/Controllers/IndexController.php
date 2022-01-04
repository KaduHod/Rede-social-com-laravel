<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Publicacao;
use App\Models\Comments;
function ordenaPubsPorData($array_de_pubs){
    usort($array_de_pubs, function ( $a, $b ) {
        return strtotime($a->created_at) - strtotime($b->created_at);
    });
    return $array_de_pubs;
}
class IndexController extends Controller
{
    public function index(){
        
        return view('welcome');
        
    }
    
}
