@extends('layouts.main')

@section('title','Crud')
@section('content')
<div class="flexcenter">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="tituloEditUserContainer" style="display: flex;heigth:fit-content;">
        <h1>Editar perfil</h1> <a href="/editLayout"> <h1>Customizar layout</h1></a>
    </div>
    
    <form action="/tabelaDeUsuarios/edit" class='form-control editForm' method="post" enctype='multipart/form-data'>
        @csrf
        <input type="hidden" name="id" value='{{$user->id}}'>
        <input type="hidden" name="pwdDB" value='{{$user->password}}'>
        <input type="hidden" name="emailDB" value='{{$user->email}}'>
        <input type="hidden" name="imageOld"  value='{{$user->image}}'> <br>


        <label for="Nome_Completo">Nome completo</label>
        <input class='form-control' name="Nome_Completo" type="text" value='{{$user->Nome_Completo}}'>
        <label for="name">Username</label>
        <input class='form-control' name="name" type="text" value='{{$user->name}}'>
        <label for="email" >Email</label>
        <input class='form-control'name="email" type="text" value='{{$user->email}}'>
        <label for="password" name="">Senha</label>
        <input class='form-control'name="password" type="password" >
        
        @if(Auth::user()->isAdmin == 1)
            <label for="Admin">Permissão de administrador</label>
            <select name="Admin" class='form-select' id="admin">
                @if($user->isAdmin == 1)
                    <option value="1">Permissão de admin</option>
                    <option value="0">Permissão de usuario</option>
                @else
                    <option value="0">Permissão de usuario</option>
                    <option value="1">Permissão de admin</option>
                @endif
                
                
            </select>
        @else
            <input type="hidden" name="Admin" value="0">
        @endif
        <div class="mb-3">
            <label for="image" class="form-label">Foto de perfil</label>
            <input type="file" name="image" class='form-control' id="image" style='margin-top:5px' value='{{$user->image}}'>
        </div>
        
        
        <button style='margin-top:10px' class='btn btn-primary' type="submit">Editar <ion-icon name="create"></ion-icon></button>
    </form>
</div>

@endsection