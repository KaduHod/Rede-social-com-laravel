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
        //dd($request->all());
        $queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();

        $newPub = new Publicacao;

        $newPub->user_id = Auth::user()->id;
        $newPub->descricao = $request->description;
        $newPub->tags = $request->tags;
        $newPub->pubUserName = Auth::user()->name;
        $newPub->profileUserImage = Auth::user()->image;
        
        
        if($request->hasFile('image') && $request->file('image')->isValid()){
            
            $extension = $request->image->extension();
            $imageName = md5($request->image->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            $request->image->move(public_path('img/pubPictures'), $imageName);
            $newPub->image = $imageName;

        }
        if($request->usuariosLinkados){
            $arrayUserLinkedIds = [];
            $arrayUsuariosLinkadosComId = [];
            $arrayUsuariosLinkados = explode(',',$request->usuariosLinkados);
            if(is_array($arrayUsuariosLinkados)){
                foreach($arrayUsuariosLinkados as $userLinked){
                    $user = User::where('name','=',$userLinked)->get();
                   // dd($user[0]->id);
                    array_push($arrayUsuariosLinkadosComId, [$user[0]->id,$user[0]->name]);
                    array_push($arrayUserLinkedIds, $user[0]->id);
                }
            }
            //dd($arrayUserLinkedIds);
            
            $newPub->userLinkedIds = implode(',',$arrayUserLinkedIds);
            $newPub->userLinked = $arrayUsuariosLinkadosComId;
        }else{
            $newPub->userLinkedIds = null;
            $newPub->userLinked = null;
        }
        
        
        
        $newPub->private = intval($request->privado);
        $newPub->save();

        return redirect('profile');
        
        
    }

    public function likePub($idPub){
        $pub = Publicacao::findOrFail($idPub);
        DB::table('likes')->insert([
            'pubId'=>$idPub,
            'likeCameFromUserId' => Auth::user()->id,
            'UserLikeProfilePic' => Auth::user()->image,
            'usernameLike' => Auth::user()->name
        ]);

        //criar dado de notificação para usuario dono da publicação com informaç~eos do auth::user()
        DB::table('notifications')->insert([
            'user_id' => $pub->user_id,
            'outsider_Id' => Auth::user()->id,
            'outsiderUserName' => Auth::user()->name,
            'msg' => 'Curtiu a sua publicação!',
            'visualized'=>0
        ]);

        return back();
    }

    public function deslikePub($idPub){
        $pub = Publicacao::findOrFail($idPub);
        DB::table('likes')->where('pubId','=',$idPub)->where('likeCameFromUserId','=',Auth::user()->id)->delete();
        DB::table('notifications')->insert([
            'user_id' => $pub->user_id,
            'outsider_Id' => Auth::user()->id,
            'outsiderUserName' => Auth::user()->name,
            'msg' => 'Descurtiu a sua publicação!',
            'visualized'=>0
        ]);

        return back();
    }

    public function comment(Request $request){
        
        $coment = new Comments;
        $coment->publicacao_id = $request->idPub;
        $coment->user_coment_id = Auth::user()->id;
        $coment->user_name = Auth::user()->name;
        $coment->user_coment_profilePic = Auth::user()->image;
        $coment->coment = $request->Comentario;
        $coment->save();
        $pub = Publicacao::findOrFail($request->idPub);
        DB::table('notifications')->insert([
            'user_id' => $pub->user_id,
            'outsider_Id' => Auth::user()->id,
            'outsiderUserName' => Auth::user()->name,
            'msg' => 'Comentou na sua publicação!',
            'visualized'=>0
        ]);

        return back();
    }
}
