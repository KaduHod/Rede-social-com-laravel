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
use App\Models\User_followers;
use App\Models\User_follows;

function ordenaPubsPorData($array_de_pubs){
    usort($array_de_pubs, function ( $a, $b ) {
        return strtotime($a->created_at) - strtotime($b->created_at);
    });
    return $array_de_pubs;
}





class UserController extends Controller
{
    public function dashboard(){        
        $pubs = [];
        $follows_ids = [];

        foreach(Auth::user()->following as $follow){
            array_push($follows_ids, $follow->id);
        }    
        foreach($follows_ids as $id){
            $query = Publicacao::orderBy('created_at','DESC')->where('user_id','=',$id)->get();
            foreach($query as $pub){
                array_push($pubs,$pub);
            }
        }
        
        $pubsOrdenadasPorData = array_reverse(ordenaPubsPorData($pubs));
        
        $arrayPubs = [];
        foreach($pubsOrdenadasPorData as $pub){           
            array_push($arrayPubs,$pub);
        }
        $pubs = $arrayPubs;
        return view('user.dashboard',compact('pubs'));
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
        /* $pubs = Publicacao::orderBy('created_at','DESC')->get();
        
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
        
         */
        $msg = 'bem vindo';
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);
        if (!Auth::attempt($attr)) {
            return redirect('/logar',)->with('msg','Senha ou email incorreto!');
        }else{
            //return redirect('/dashboard');
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
        
        
        return view('user.tabelaDeUsuarios',compact(
            'users'
        ));
    }
    public function editUser($id){
        $user = User::findOrFail($id);
               
        return view('user.editUser',compact(
            'user'
        ));
        
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

        
        

        return redirect('tabelaDeUsuarios')->with('msg','Usuario atualizado com sucesso!');    
        
    }
    public function destroy($id){
        
        User::where('id',$id)->delete();

        return redirect('/tabelaDeUsuarios')->with('msg','Usuario deletado com sucesso!');
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
        //$queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();
        
        return view('user.search',compact('searchUser','search')) ;
    }
    public function profile(){
        $Following = Auth::user()->following()->get();
        $Followers = Auth::user()->followers()->get();
        //$pubs = Auth::user()->publicacao()->get();
        //dd(Auth::user()->publicacao);
        //dd($pubs);
        
        /* $publicacoes = Publicacao::where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->get();
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
            
        }*/

        
        

        
    
        return view('user.profile',compact(
            'Following',
            'Followers'
            //'queryNotifications',
            //'pubs'
            )
        );
    }
    public function outsiderProfile($id){
        if(Auth::user()->id == $id){
            return redirect('/profile');
        }

        $user = User::findOrFail($id);
        $pubs = [];
        foreach($user->publicacao as $pub){
            //$comment = Comments::where('publicacao_id','=',$pub->id)->get();
            $publicacao = [
                'infoPub' => $pub,
                'ownerPub' => $pub->user()->get()[0]
                //'infoComent' => Comments::where('publicacao_id','=',$pub->id)->get(),
                //'infoLike' => DB::table('likes')->where('pubId','=',$pub->id)->get()
            ];
            //dd($publicacao);
            array_push($pubs, $publicacao);
            
        }
        //dd($pubs); 

        
        $followings = [];
        foreach(Auth::user()->following as $follower){
            array_push($followings, $follower->id);
        }
        $verificaSeUserJaSegueOutsiderProfile = array_search($id, $followings);
        
        $actionEbotao = $verificaSeUserJaSegueOutsiderProfile > -1 ? ["botao" => 'Deixar de seguir ', "action"=> "/registerUnfollow"] :["botao" => 'Seguir ', "action"=> "/registerFollow"] ;
        
        $Following = $user->following()->get();
        $Followers = $user->followers()->get();  
        

        return view('user.outsiderProfile', compact(
            'user',
            'Following',
            'Followers',
            'actionEbotao',
            //'queryNotifications',
            //'queryFollowsIMAGENAME',
            //'queryFollowersIMAGENAME',
            'pubs'
        ));
    }

    public function follow($outsiderid){
        $user = User::findOrFail($outsiderid);
        Auth::user()->following()->attach($user);
        
        return back();
    }
    public function unFollow($outsiderid){
        $user = User::findOrFail($outsiderid);
        Auth::user()->following()->detach($user);
       
        return back();
    }

    public function visualizarNotificação($idNotificação){
       
        return redirect('/');
    }
    
}
