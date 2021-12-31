@extends('layouts.main')

@section('title','Crud')
@section('content')

<h1>Bem vindo {{Auth::user()->name}}</h1>

<div id="pubContainer" >
    @foreach($pubs as $pub)

    <div class="card cardPub sombraCard">
        <div class="pubUserInfo">
            <div class="pubUserPic" style="background-image: url('/img/profilePictures/{{$pub->user->image}}"> 
                
            </div>
            <div class='pubUserInfoUserName'>
            <a class='' href="/outsiderProfile/{{$pub->user->id}}">{{$pub->user->name}}</a>
            @if($pub->userLinked)
                com
                @foreach($pub->userLinked as $userLinked)
                    @if($loop->index == 0)
                        <a class='' href="/outsiderProfile/{{$userLinked[0]}}">{{$userLinked[1]}}</a>
                    @else
                        @if($loop->index == count($pub->userLinked)-1)
                            e&nbsp;<a class='' href="/outsiderProfile/{{$userLinked[0]}}">{{$userLinked[1]}}</a>
                        @else
                            ,&nbsp;<a class='' href="/outsiderProfile/{{$userLinked[0]}}">{{$userLinked[1]}}</a>
                        @endif
                    @endif 
                @endforeach
            @endif
        </div>

        </div>
        
        <a href="/pub/{{$pub->id}}" class="LinkToPub">
            <div class="pubImage" style="background-image: url('/img/pubPictures/{{$pub->image}}')">
            </div>
        </a>
         <div class="likeShareDateBox">
            <div>
                @php
                  $link = '/like';
                  $classe = 'iconeDescurtido';  
                @endphp 
                    @foreach($pub->likes as $likes)
                        @if($likes->user_id == Auth::user()->id)
                                @php
                                    $link = '/deslike';
                                    $classe = 'iconeCurtido';
                                @endphp
                            @endif
                    @endforeach  
                    <a href="{{$link}}/{{$pub->id}}"><ion-icon class="icone  {{$classe}} "  name="heart-outline"></ion-icon></a>
                    <div class="countBox">{{count($pub->likes)}} </div>                    
            </div> 
            <div>
                <ion-icon class="icone iconeComentarios" name="create-outline" id='{{$pub->id}} '></ion-icon>
                <div class="countBox">{{count($pub->comments)}}</div>
            </div>
            <div>
                <ion-icon class="icone "  name="share-social-outline"></ion-icon>
                <div class="countBox"></div>
            </div>
        </div> 
        <div class="card-body">
            @php
                $new_date = new DateTime($pub->created_at) ;
                $dataFormatada = $new_date->format('d/m/y - H:i')  ;
            @endphp
            <div class="date">
               {{$dataFormatada}}
            </div>
            @if($pub->tags)
                <p>{{$pub->tags}}</p>
            @endif
            <p id="verDescricao{{$pub->id}}" class="botaoDescrição">Ver descrição...</p>
            <div id='containerDescription{{$pub->id}}' class="descriptionPub">
                <p id="texto{{$pub->id}}" class="hidden">{{$pub->descricao}}</p>
            </div>            
        </div>
            
            
        <ul class="ulComents" id="ulComments{{$pub->id}}">
            <h5>Comentarios</h5>
            
            @if(count($pub->comments)> 0)
                @foreach($pub->comments as $comment)
                    <li class="coment">
                        <div class='comentUserPic' style="
                        background-image: url('/img/profilePictures/{{$comment->user->image}}')
                        "></div>
                        
                        <div class="comentInfoBox">
                            <div class="commentLinkDate">
                                <a class="linkUserName" style='margin-rigth:10px;' href="/outsiderProfile/{{$comment->user->id}}">{{$comment->user->name}}</a>
                                @php
                                    $new_date_coment = new DateTime($comment->created_at) ;
                                    $dataFormatada = $new_date_coment->format('d/m/y - H:i')  ;
                                @endphp
                                <div class="dateComment">{{$dataFormatada}}</div>
                                @if($comment->user->id == Auth::user()->id)
                                    <a class='comentIcon'  href="/editComent/{{$pub->id}}/{{$comment->id}}">Excluir</ion-icon></a>
                                @endif
                            </div>
                            <div  class="comentText">
                                {{$comment->coment}}
                            </div>
                            
                        </div>
                        
                     </li>
                @endforeach
            @else 
                <p class="coment">Sem comentarios ainda.</p>
             @endif  
        </ul>
            
            
        <form action='/coment' method="post" class="input-group  ">
            @csrf
            <input type="text" class="form-control inputComments" name='Comentario' placeholder="Deixe o seu comentario..." aria-describedby="basic-addon2">
            <input type="hidden" name='idPub' value={{$pub->id}}>
            <div class="input-group-append">
                  <input type='submit' class="btn btn-outline-secondary botao" value='Enviar' >              
            </div>
        </form>
            
            
    </div>
        
    @endforeach
</div>

@endsection