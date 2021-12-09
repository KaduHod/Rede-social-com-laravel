@extends('layouts.main')

@section('title','Crud')
@section('content')
<h1>Crud em laravel</h1>
@if(Auth::user())
<h1>Bem vindo {{Auth::user()->name}}</h1>
@else
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <h1><a href="/logar">Logue-se para vizualizar usuarios</a></h1>

@endif


@endsection