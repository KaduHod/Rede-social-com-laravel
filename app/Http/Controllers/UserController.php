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
        return view('user.login');
    }
    public function telaDeRegistro(){
        return view('user.registro');
    }
    public function liberarUser(Request $request){
        //dd($request->all());
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return redirect('/logar')->with('msg','Senha ou email incorreto!');
            //return redirect()->intended('/login');
            
        }else{
            return view('user.dashboard');
        }
    }
    public function reg(){
        return view('user.registro');
    }
    public function logout(){
        Auth::logout();
        return redirect('/logar');
    }
    public function store(UserStoreRequest $request){
        
        $pwd = Hash::make($request->Senha);
        
        $userDB = new User;
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
        

        return view('user.tabelaDeUsuarios',['users'=>$users]);
    }
    public function editUser($id){
        $user = User::findOrFail($id);
        
        return view('user.editUser',['user'=>$user]);
        
    }
    public function edit(UserEditRequest $request){
       // dd($request->all());


        $user = User::findOrFail($request->id);
        
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
            unlink('img/profilePictures/' . $oldProfilePicture);
        }

        $user->save();


        return redirect('/tabelaDeUsuarios')->with('msg','Usuario atualizado com sucesso!');

         
        //
        

        
          
        
    }
    public function destroy($id){
        
        User::where('id',$id)->delete();
        return redirect('/tabelaDeUsuarios')->with('msg','Usuario deletado com sucesso!');
    }
    public function search(){
        $search = request('search');

        $searchUser = User::where([
            ['name', 'like','%' . $search . '%']
        ])->get();

        
        return view('user.search',['searchUser'=>$searchUser, 'search'=>$search]) ;
    }
}
