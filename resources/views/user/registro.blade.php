@extends('layouts.main')

@section('title','Crud')
@section('content')
<div id='LoginRegister'>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="row" style='width:50%'>
        <div class="col-md-6 offset-md-3">
            <form action="/reg" method='post' enctype='multipart/form-data'>
                @csrf
                <div class="form-group">
                    <label for="Username">User name</label>
                    <input type="text" name='Username' id='Username' class="form-control">
                </div>
                <div class="form-group">
                    <label for="Nome_Completo">Nome completo</label>
                    <input type="text" name='Nome_Completo' id='Nome_Completo' class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="Email">Email</label>
                    <input type="email" name='Email' id='Email' class="form-control">
                </div>
                <div class="form-group">
                    <label for="Senha">Senha</label>
                    <input type="password" name='Senha' id='Senha' class="form-control">
                </div>
                <div class="form-group">
                    <label for="Confirmação_de_senha">Confirme a senha</label>
                    <input type="password" name='Confirmação_de_senha' id='Confirmação_de_senha' class="form-control">
                </div>
                <div class="form-group">
                    <label for="image">Foto de perfil</label>
                    <input type="file" name='image' id='image' class="form-control-file">
                </div>
                <div class="form-group " style='margin-top:10px'>
                    <button type="submit" class='btn btn-primary'>Registrar</button>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endsection