@extends('layouts.main')

@section('title','Crud')
@section('content')
<div class="flexcenter" >
<h1>Busca: {{$search}}</h1>
<div id='container_de_users'>
    @foreach($searchUser as $user)
    <div class="card" id='card_user' >
        <div class='imageContainer' style='background-image:url(img/profilePictures/{{$user->image}})'>

        </div>
        <!-- <--<img class="img-fluid imagePerfil "    src="img/profilePictures/{{$user->image}}" alt="Card image cap">-->
        <div class="card-body">
            <h5 class="card-title">{{$user->name}}</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="/outsiderProfile/{{$user->id}}" class="btn btn-dark">{{$user->name}}</a>
        </div>
    </div>
    @endforeach
</div>
    
</div>

@endsection