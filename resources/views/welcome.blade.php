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
@foreach($pubs as $pub)
    <div style='border:5px solid blue'>
        <div style='border:1px solid red'>
            <div class='circle'>{{$pub->profileUserImage}}</div>
            <div>{{$pub->pubUserName}}</div>
        </div>
        <div>{{$pub->image}}</div>
        <p>descricão:{{$pub->description}}</p>
        <p>tags:{{$pub->tags}}</p>
    </div>
@endforeach
    <h1><a href="/logar">Logue-se para vizualizar usuarios</a></h1>

@endif


@endsection