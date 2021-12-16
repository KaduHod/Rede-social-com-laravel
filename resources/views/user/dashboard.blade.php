@extends('layouts.main')

@section('title','Crud')
@section('content')

<h1>Bem vindo {{Auth::user()->name}}</h1>


@foreach($pubs as $pub)
    <div style='border:1px solid blue'>
        <div style='border:1px solid red'>
            <div class='circle'>{{$pub->profileUserImage}}</div>
            <div>{{$pub->pubUserName}}</div>
        </div>
        <div>{{$pub->image}}</div>
        <p>descricão:{{$pub->description}}</p>
        <p>tags:{{$pub->tags}}</p>
    </div>
@endforeach

@endsection