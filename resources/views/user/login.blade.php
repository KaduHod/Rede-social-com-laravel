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
            <form action="/login" method='post'>
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name='email' id='email' class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" name='password' id='password' class="form-control">
                </div>
                <div class="form-group " style='margin-top:10px'>
                    <button type="submit" class='btn btn-primary'>Logar</button>
                    <a class='btn btn-primary' href="/registrar">Registre-se</a>
                </div>
                
            </form>
        </div>
    </div>
</div>

@endsection