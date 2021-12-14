@extends('layouts.main')

@section('title','Crud')
@section('content')
<div  id='profileTop'>
    <div id="imgProfileContainer" style="
                        background-image:url('/img/profilePictures/{{$user->image}}')
                    " class='rounded-circle'>

    </div>
    <div id="profileInfoBasic">
        <span>Seguidores: {{$queryFollowers->count()}}</span>
        <span>Seguindo: {{$queryFollows->count()}}</span>
        <span>Publicações: X</span>
    </div>
        <form action="{{$actionEbotao['action']}}/{{$user->id}}" method='get'>
            <button style="margin:10px 0px 10px 0px; color:white" class='btn btn-dark' type='submit'>{{$actionEbotao['botao']}}</button>
        </form>
    
    
</div>
<div id="Publicações">
    
    
    Publicações de {{$user->Nome_Completo}}
    
    
</div>

@endsection