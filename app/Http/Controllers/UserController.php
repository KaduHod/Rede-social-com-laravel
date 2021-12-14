<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserEditRequest;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
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
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return redirect('/logar',)->with('msg','Senha ou email incorreto!');
        }else{
            $queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();
            return view('user.dashboard',['queryNotifications'=>$queryNotifications]);
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
    
        return view('user.profile',['queryFollows'=>$queryFollows, 'queryFollowers'=>$queryFollowers, 'queryNotifications'=>$queryNotifications,'queryFollowsIMAGENAME'=>$queryFollowsIMAGENAME, 'queryFollowersIMAGENAME'=>$queryFollowersIMAGENAME]);
    }

    public function outsiderProfile($id){
        $user = User::findOrFail($id);
        $queryFollows = DB::table('user_follows')->where('user_id',$user->id)->get();
        
        
        $queryFollowers = DB::table('user_follows')->where('follows_id',$user->id)->get();  

        $idFollows = [];
        foreach($queryFollows as $follows){
            array_push($idFollows,$follows->follows_id);
        }
        
        //var_dump($idFollows);
       
        $idFollowers = [];
        foreach($queryFollowers as $follower){
            array_push($idFollowers,$follower->user_id);
        }
        //var_dump($idFollowers);
        // logica para de qual boão colocar na view

        $Botao = null;
        if(Auth::user()->id == $user->id){
            return redirect('/profile');
        }
                        
        $verificaSeUserJaSegueOutsiderProfile = array_search(Auth::user()->id,$idFollowers);
        $actionEbotao = $verificaSeUserJaSegueOutsiderProfile > -1 ?  ["botao" => 'Deixar de seguir ', "action"=> "/registerUnfollow"]:["botao" => 'Seguir ', "action"=> "/registerFollow"];
            
        $queryNotifications = DB::table('notifications')->where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->where('visualized','=',0)->get();
        return view('user.outsiderProfile',['user'=>$user, 'queryFollows'=>$queryFollows, 'queryFollowers'=>$queryFollowers,'actionEbotao'=>$actionEbotao,'queryNotifications'=>$queryNotifications]);
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
