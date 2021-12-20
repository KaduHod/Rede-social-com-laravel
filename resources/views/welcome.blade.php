@extends('layouts.main')

@section('title','Crud')
@section('content')

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
<div id="pubContainer">
    @foreach($pubs as $pub)

    <div class="card cardPub">
        <div class="pubUserInfo">
            <div class="pubUserPic" style="background-image: url('/img/profilePictures/{{$pub['infoPub']->profileUserImage}}"> 
                
            </div>
            <div class='pubUserInfoUserName'>
                <a class='' href="/outsiderProfile/{{$pub['infoPub']->user_id}}">{{$pub['infoPub']->pubUserName}}</a>
                @if($pub['infoPub']->userLinked)
                    com
                    @foreach($pub['infoPub']->userLinked as $userLinked)
                        @if($loop->index == 0)
                            <a class='' href="/outsiderProfile/{{$userLinked[0]}}">{{$userLinked[1]}}</a>
                        @else
                            @if($loop->index == count($pub['infoPub']->userLinked)-1)
                                e&nbsp;<a class='' href="/outsiderProfile/{{$userLinked[0]}}">{{$userLinked[1]}}</a>
                            @else
                                ,&nbsp;<a class='' href="/outsiderProfile/{{$userLinked[0]}}">{{$userLinked[1]}}</a>
                            @endif
                        @endif 
                    @endforeach
                @endif
            </div>

        </div>
        
        <div class="pubImage" style="background-image: url('/img/pubPictures/{{$pub['infoPub']->image}}')">
        </div>
        <div class="likeShareDateBox">
            <div>
                @php
                  $link = '/like';
                  $classe = 'iconeDescurtido';  
                @endphp
                    @foreach($pub['infoLike'] as $like)
                        @if(Auth::user() && $like->likeCameFromUserId == Auth::user()->id)
                            @php
                                $link = '/deslike';
                                $classe = 'iconeCurtido';
                            @endphp
                            
                        @else
                            @php
                                $link = '/like';
                                $classe = 'iconeDescurtido';
                            @endphp
                             
                        @endif
                    @endforeach
                    @if(!Auth::user())
                        
                        <a href="/logar"><ion-icon class="icone {{$classe}}"  name="heart"></ion-icon></a>
                        <div class="countBox">{{count($pub['infoLike'])}}</div>
                    @else
                        <a href="{{$link}}/{{$pub['infoPub']->id}}"><ion-icon class="icone {{$classe}}"  name="heart"></ion-icon></a>
                        <div class="countBox">{{count($pub['infoLike'])}}</div>
                    @endif                    
                    
            </div>
            <div>
                <ion-icon class="icone iconeComentarios" name="create" id='{{$pub['infoPub']->id}}'></ion-icon>
                <div class="countBox">{{count($pub['infoComent'])}} </div>
            </div>
            <div>
                <ion-icon class="icone "  name="share"></ion-icon>
                <div class="countBox"></div>
            </div>
        </div>
        <div class="card-body">
            @if($pub['infoPub']->tags)
                <p>{{$pub['infoPub']->tags}}</p>
            @endif
            <p id="verDescricao{{$pub['infoPub']->id}}" class="botaoDescrição">Ver descrição...</p>
            <div id='containerDescription{{$pub['infoPub']->id}}' class="descriptionPub">
                    <p id="texto{{$pub['infoPub']->id}}" class="hidden">{{$pub['infoPub']->descricao}}</p>
            </div>            
        </div>
            
            
        <ul class="ulComents" id="ulComments{{$pub['infoPub']->id}}">
            <h5>Comentarios</h5>
            @if(count($pub['infoComent'])> 0)
                @foreach($pub['infoComent'] as $comment)
                    <li class="coment"><div class='comentUserPic' style="
                            background-image: url('/img/profilePictures/{{$comment->user_coment_profilePic}}')
                            "></div> {{$comment->coment}} </li>
                @endforeach
            @else
                <p class="coment">Sem comentarios ainda.</p>
            @endif                
        </ul>
            
        <form action='/coment' method="post" class="input-group  ">
            @csrf
            <input type="text" class="form-control inputComments" name='Comentario' placeholder="Deixe o seu comentario..." aria-describedby="basic-addon2">
            <input type="hidden" name='idPub' value={{$pub['infoPub']->id}}>
            <div class="input-group-append">
              <input type='submit' class="btn btn-outline-secondary botao" value='Enviar' >
                          
            </div>
        </form>
            
    </div>
        
    @endforeach
</div>
    

@endif


@endsection