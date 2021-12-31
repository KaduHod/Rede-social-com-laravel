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
use App\Models\Comments;

class PubController extends Controller
{
    public function createPub(){
        $users = User::all();
        $followers = Auth::user()->followers()->get();
        
        return view('pub.create', compact('followers'));
    }

    public function store(Request $request){     
        //dd($request->all());
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $extension = $request->image->extension();
            $imageName = md5($request->image->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            $request->image->move(public_path('img/pubPictures'), $imageName);
        }
        if($request->usuariosLinkados){
            $arrayUserLinkedIds = [];
            $arrayUsuariosLinkadosComId = [];
            $arrayUsuariosLinkados = explode(',',$request->usuariosLinkados);
            if(is_array($arrayUsuariosLinkados)){
                foreach($arrayUsuariosLinkados as $userLinked){
                    $user = User::where('name','=',$userLinked)->get();
                    array_push($arrayUsuariosLinkadosComId, [$user[0]->id,$user[0]->name]);
                    array_push($arrayUserLinkedIds, $user[0]->id);
                }
            }            
            $userLinkedIds = implode(',',$arrayUserLinkedIds);
            $userLinked = $arrayUsuariosLinkadosComId;
        }else{
            $userLinkedIds = null;
            $userLinked = null;
        }
        
        Auth::user()->publicacao()->create([
            'user_id'=>Auth::user()->id,
            'descricao'=>$request->description,
            'tags'=>$request->tags,
            'image'=>$imageName,
            'userLinkedIds'=>$userLinkedIds,
            'userLinked'=>$userLinked,
            'private'=>intval($request->privado)
        ]);
        return redirect('profile');
        
        
    }

    public function likePub($idPub){
        $pub = Publicacao::findOrFail($idPub);
        //dd(Auth::user()->publicacao);
        $pub->likes()->create([
            'user_id' => Auth::user()->id,
            'pub_id' => $pub->id
        ]);
        
        return back();
    }

    public function deslikePub($idPub){
        $pub = Publicacao::findOrFail($idPub);
        $pub->likes()->where('user_id','=',Auth::user()->id)->delete();

        return back();
    }

    public function comment(Request $request){
        if($request->Comentario == '' || $request->Comentario == null ){
            return back();
        }
        Auth::user()->comments()->create([
            'publicacao_id' => $request->idPub,
            'user_id' => Auth::user()->id,
            'coment' => $request->Comentario
        ]);
        return back();
    }
    public function destroyComment($pubId, $commentId){
        //dd(Auth::user()->comments());
        //$pub = Publicacao::findOrFail($pubId);
        //dd($pub->comments()->where('id','=',$commentId)->get());
        Auth::user()->comments()->where('id','=',$commentId)->delete();
        return back();

    }
    public function show($pubId){
        $pub = Publicacao::findOrFail($pubId);
        
       return view('pub.show',compact('pub'));
    }
}
