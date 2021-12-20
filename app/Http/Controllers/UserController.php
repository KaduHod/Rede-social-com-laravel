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

function ordenaPubsPorData($array_de_pubs){
    usort($array_de_pubs, function ( $a, $b ) {
        return strtotime($a->created_at) - strtotime($b->created_at);
    });
    return $array_de_pubs;
}





class UserController extends Controller
{
    public function dashboard(){
        $follows = DB::table('user_follows')->where('user_id','=',Auth::user()->id)->get();
        //dd($follows);
        $follows_ids = [];

        foreach($follows as $follow){
            array_push($follows_ids, $follow->follows_id);
        }   
       
        

        $pubs = [];
        foreach($follows_ids as $id){
            $query = Publicacao::orderBy('created_at','DESC')->where('user_id','=',$id)->get();
            foreach($query as $pub){
                array_push($pubs,$pub);
            }
        }
        $pubsOrdenadasPorData = array_reverse(ordenaPubsPorData($pubs));
        //dd($pubsOrdenadasPorData);
        // $pubs = Publicacao::orderBy('created_at','DESC')->get();
        // dd($pubs);
         $publicacoes = [];
        foreach($pubsOrdenadasPorData as $pub){
            $comment = Comments::where('publicacao_id','=',$pub->id)->get();
            $publicacao = [
                'infoPub' => Publicacao::where('id','=',$pub->id)->get()[0],
                'infoComent' => Comments::where('publicacao_id','=',$pub->id)->get(),
                'infoLike' => DB::table('likes')->where('pubId','=',$pub->id)->get()
            ];
            //dd($publicacao);
            array_push($publicacoes, $publicacao);
            
        }
        //dd($publicacoes);
        return view('user.dashboard',['queryNotifications'=>[],'pubs'=>$publicacoes]);
    }
    
    public function telaDelogin(){
        //$queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->where('visualized','=',0)->get();
        
        return view('user.login');
    }
    public function telaDeRegistro(){
        $queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();
        return view('user.registro', ['queryNotifications'=>$queryNotifications]);
    }
    public function liberarUser(Request $request){
        //dd($request->all());
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
        
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return redirect('/logar',)->with('msg','Senha ou email incorreto!');
        }else{
            //$queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();
            return redirect('/dashboard');
        }
    }
    public function reg(){
        $queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();

        return view('user.registro', ['queryNotifications' => $queryNotifications]);
    }
    public function logout(){
        Auth::logout();
        return redirect('/logar');
    }
    public function store(UserStoreRequest $request){
        
        $pwd = Hash::make($request->Senha);
        
        $userDB = new User;
        $userDB->Nome_Completo = $request->Nome_Completo; 
        $userDB->name = $request->Username;
        $userDB->email = $request->Email;
        $userDB->password = $pwd; 
        $userDB->isAdmin = 0;
        

        //image upload
        if($request->hasFile('image') && $request->file('image')->isValid()){
            
            $extension = $request->image->extension();
            $imageName = md5($request->image->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            $request->image->move(public_path('img/profilePictures'), $imageName);

        }
        $userDB->image = $imageName;
        $userDB->save();

        

        return redirect('logar')->with('msg','Cadastro com sucesso!');
    } 
    public function tabelaDeUsuarios(){
        $users = User::all();
        
        $queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();
        
        return view('user.tabelaDeUsuarios',['users'=>$users, 'queryNotifications' => $queryNotifications]);
    }
    public function editUser($id){
        $user = User::findOrFail($id);
        $queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->where('visualized','=',0)->get();
               
        return view('user.editUser',['user'=>$user, 'queryNotifications'=> $queryNotifications]);
        
    }
    public function edit(UserEditRequest $request){
       // dd($request->all());


        $user = User::findOrFail($request->id);
        $user->Nome_Completo = $request->Nome_Completo;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->isAdmin = $request->Admin;

        if($request->senha != null){
            $user->password = Hash::make($request->Senha);
        }
        if($request->hasFile('image') && $request->file('image')->isValid()){


            $extension = $request->image->extension();
            $imageName = md5($request->image->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            $request->image->move(public_path('img/profilePictures'), $imageName);

            $user->image = $imageName;


            $oldProfilePicture = $request->imageOld; 
            unlink("img/profilePictures/$oldProfilePicture");
        }

        $user->save();

        $queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();
        

        return redirect('tabelaDeUsuarios')->with('msg','Usuario atualizado com sucesso!',compact('queryNotifications'));    
        
    }
    public function destroy($id){
        
        User::where('id',$id)->delete();

        $queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();
        return redirect('/tabelaDeUsuarios',['queryNotifications'=>$queryNotifications])->with('msg','Usuario deletado com sucesso!');
    }
    public function search(){
        $search = request('search');

        if($search){
            $searchUser = User::where([
                ['name', 'like','%' . $search . '%']
            ])->get();
        }else{  
            $searchUser = User::all();
        }
        $queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();
        
        return view('user.search',['searchUser'=>$searchUser, 'search'=>$search, 'queryNotifications'=>$queryNotifications]) ;
    }
    public function profile(){
        $publicacoes = Publicacao::where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->get();
        $pubs = [];
        foreach($publicacoes as $pub){
            $comment = Comments::where('publicacao_id','=',$pub->id)->get();
            $publicacao = [
                'infoPub' => Publicacao::where('id','=',$pub->id)->get()[0],
                'infoComent' => Comments::where('publicacao_id','=',$pub->id)->get(),
                'infoLike' => DB::table('likes')->where('pubId','=',$pub->id)->get()
            ];
            //dd($publicacao);
            array_push($pubs, $publicacao);
            
        }

        $queryFollows = DB::table('user_follows')->where('user_id',Auth::user()->id)->get();// query com os peris seguidos
        $queryFollowers = DB::table('user_followers')->where('user_id',Auth::user()->id)->get();// query com os perfis seguidores
                

        //array com seguidores (is,name,image)
        $queryFollowsIMAGENAME = [];
        foreach($queryFollows as $follow){
            array_push($queryFollowsIMAGENAME,DB::table('users')->select(['name','image','id'])->where('id','=',$follow->follows_id)->get());
        }
        
        
        

        //array com seguidos (is,name,image)
        $queryFollowersIMAGENAME = [];
        foreach($queryFollowers as $follower){
            array_push($queryFollowersIMAGENAME,DB::table('users')->select(['name','image','id'])->where('id','=',$follower->follower_id)->get());
        }
        

        $queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();
    
        return view('user.profile',compact('queryFollows','queryFollowers','queryNotifications','queryFollowsIMAGENAME','queryFollowersIMAGENAME','pubs'));
    }
    public function outsiderProfile($id){
        if(Auth::user()->id == $id){
            return redirect('/profile');
        }

        $publicacoes = Publicacao::where('user_id','=',$id)->OrderBy('created_at','DESC')->get();


        $pubs = [];
        foreach($publicacoes as $pub){
            $comment = Comments::where('publicacao_id','=',$pub->id)->get();
            $publicacao = [
                'infoPub' => Publicacao::where('id','=',$pub->id)->get()[0],
                'infoComent' => Comments::where('publicacao_id','=',$pub->id)->get(),
                'infoLike' => DB::table('likes')->where('pubId','=',$pub->id)->get()
            ];
            //dd($publicacao);
            array_push($pubs, $publicacao);
            
        }
        //dd($pubs);

        

        $user = User::findOrFail($id);
        $queryFollows = DB::table('user_follows')->where('user_id',$user->id)->get();
        $queryFollowers = DB::table('user_followers')->where('user_id',$user->id)->get();  
        $stringQueryUserIdUserName = `[["`. $user->id .`","` . $user->name . `"]`;
        //$pubs = Publicacao::where('user_id','=',$id)->get();
        
        //array com seguidores (is,name,image)
        $queryFollowsIMAGENAME = [];
        foreach($queryFollows as $follow){
            array_push($queryFollowsIMAGENAME,DB::table('users')->select(['name','image','id'])->where('id','=',$follow->follows_id)->get());
        }
        
        
        

        //array com seguidos (is,name,image)
        $queryFollowersIMAGENAME = [];
        foreach($queryFollowers as $follower){
            array_push($queryFollowersIMAGENAME,DB::table('users')->select(['name','image','id'])->where('id','=',$follower->follower_id)->get());
        }
        
        
        $idFollows = [];
        foreach($queryFollows as $follows){
            array_push($idFollows,$follows->follows_id);
        }
        
       
        $idFollowers = [];
        foreach($queryFollowers as $follower){
            array_push($idFollowers,$follower->follower_id);
        }
        //dd($idFollowers);

        $Botao = null;
        
                        
        $verificaSeUserJaSegueOutsiderProfile = array_search(Auth::user()->id,$idFollowers);
        
        $actionEbotao = $verificaSeUserJaSegueOutsiderProfile > -1 ? ["botao" => 'Deixar de seguir ', "action"=> "/registerUnfollow"] :["botao" => 'Seguir ', "action"=> "/registerFollow"] ;
        
        
        $queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();


        return view('user.outsiderProfile', compact('user', 'queryFollows','queryFollows','queryFollowers','actionEbotao','queryNotifications','queryFollowsIMAGENAME','queryFollowersIMAGENAME','pubs'));
    }

    public function follow($outsiderid){
        DB::table('user_follows')->insert([
            'user_id'=> Auth::user()->id,
            'follows_id' => $outsiderid
        ]);
        DB::table('user_followers')->insert([
            'user_id'=> $outsiderid,
            'follower_id' => Auth::user()->id
        ]);
        
        //adicionar notificação de novo seguidor ao follower id
        DB::table('notifications')->insert([
            'user_id' => $outsiderid,
            'msg' => 'começou a seguir você!',
            'outsider_id' => Auth::user()->id,
            'visualized' => 0,
            'outsiderUserName' => Auth::user()->name
        ]);
        $queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();
        return back();
    }
    public function unFollow($outsiderid){
        DB::table('user_follows')->where('user_id','=',Auth::user()->id)->where('follows_id','=',$outsiderid)->delete();

        DB::table('user_followers')->where('user_id','=',$outsiderid )->where('follower_id','=',Auth::user()->id)->delete();
        
        DB::table('notifications')->where('user_id','=',Auth::user()->id)->where('outsiderUser','=',$outsiderid)->insert([
            'user_id' => $outsiderid,
            'msg' => 'deixou de seguir você',
            'outsider_id' => Auth::user()->id,
            'visualized' => 0,
            'outsiderUserName' => Auth::user()->name
        ]);
        $queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();
        return back();
    }

    public function visualizarNotificação($idNotificação){
        DB::table('notifications')->where('id','=',$idNotificação)->update(['visualized'=>1]);
        return redirect('/');
    }
    
}
