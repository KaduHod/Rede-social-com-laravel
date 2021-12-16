@extends('layouts.main')

@section('title','Crud')
@section('content')
<div  id='profileTop'>
    <div id="imgProfileContainer" style="
                        background-image:url('/img/profilePictures/{{$user->image}}')
                    " class='rounded-circle'>

    </div>
    <div id="profileInfoBasic">
        <span id='follows' >Seguidores: {{$queryFollowers->count()}}</span>
        <span id='followers'>Seguindo: {{$queryFollows->count()}}</span>
        <span>Publicações: X</span>
    </div>
        <form action="{{$actionEbotao['action']}}/{{$user->id}}" method='get'>
            <button style="margin:10px 0px 10px 0px; color:white" class='btn btn-dark' type='submit'>{{$actionEbotao['botao']}}</button>
        </form>
    
    
</div>

<div class="notificationsBox" id='followsBox'>
    <div id='closeFollowsBox' style='display:flex;justify-content:flex-end;'>
        <ion-icon style='width:20px;height:20px' name="close"></ion-icon>
    </div>
    <div class='flexContainerNot'>
        <h2 style='margin-top:5px'>Seguidores</h2>
        <ul id='listaNot'>
        @foreach($queryFollowersIMAGENAME as $follower)
            <li><div class='indexBox'>&nbsp;{{$loop->index + 1}}</div>   <a class='linkUser' href="/outsiderProfile/{{$follower[0]->id}}">&nbsp; <div class='linkUserProfilePicture ' style='background-image:url(/img/profilePictures/{{$follower[0]->image}})'></div> {{$follower[0]->name}}</a>   </li>
        @endforeach
        </ul>
                        
    </div>                
</div>




<div class="notificationsBox" id='followersBox'>
    <div id='closeFollowersBox' style='display:flex;justify-content:flex-end;'>
        <ion-icon style='width:20px;height:20px' name="close"></ion-icon>
    </div>
    <div class='flexContainerNot'>
        <h2 style='margin-top:5px'>Seguindo</h2>
        <ul id='listaNot'>
       @foreach($queryFollowsIMAGENAME as $follow)
            
            <li><div class='indexBox'>&nbsp;{{$loop->index + 1}}</div><a class='linkUser' href="/outsiderProfile/{{$follow[0]->id}}"> &nbsp; <div class='linkUserProfilePicture' style='background-image:url(/img/profilePictures/{{$follow[0]->image}})'></div> {{$follow[0]->name}}</a>   </li>
        @endforeach
        </ul>              
    </div>           
</div>
<div id="Publicações">
    
    
    Publicações de {{$user->Nome_Completo}}
    
    
</div>

@endsection