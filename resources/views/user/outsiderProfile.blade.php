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
        <span>Publicações: {{count($pubs)}}</span>
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
                        @if($like->likeCameFromUserId == Auth::user()->id)
                            
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
                    <a href="{{$link}}/{{$pub['infoPub']->id}}"><ion-icon class="icone {{$classe}}"  name="heart"></ion-icon></a>
                    <div class="countBox">{{count($pub['infoLike'])}}</div>               
                    
                    
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
                @php
                $new_date = new DateTime($pub['infoPub']->created_at) ;
                $dataFormatada = $new_date->format('d/m/y - H:i')  ;
                @endphp
               <div class="date">
                   {{$dataFormatada}}
               </div>
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

{{-- <div id="pubContainer">
    @if(count($pubs)>0)
        @foreach($pubs as $pub)
        <div class="card cardPub">
            <div class="pubUserInfo">
                <div class="pubUserPic" style="background-image: url('/img/profilePictures/{{$pub->profileUserImage}}">
                    
                </div>
            <div class='pubUserInfoUserName'>
                <a class='' href="/outsiderProfile/{{$pub->user_id}}">{{$pub->pubUserName}}</a>
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
            
                <div class="pubImage" style="background-image: url('/img/pubPictures/{{$pub->image}}')">

                </div>
                <div class="likeShareDateBox">
                    <ion-icon class="icone iconeDescurtido"  name="heart"></ion-icon>
                    <ion-icon class="icone iconeComentarios" name="create" id='{{$pub->id}}'></ion-icon>
                    <ion-icon class="icone "  name="share"></ion-icon>
                    
                    
                </div>
                <div class="card-body">
                    @if($pub->tags)
                        <p>{{$pub->tags}}</p>
                    @endif
                    <p id="verDescricao{{$pub->id}}" class="botaoDescrição">Ver descrição...</p>
                    <div id='containerDescription{{$pub->id}}' class="descriptionPub">
                        <p id="texto{{$pub->id}}" class="hidden">{{$pub->descricao}}</p>
                    </div>            
                </div>
                
                
                <ul class="ulComents" id="ulComments{{$pub->id}}">
                    <li class="coment">comentario</li>
                    <li class="coment">comentario</li>
                </ul>
                
                
                <form  method="post" class="input-group  ">
                    
                    <input type="text" class="form-control inputComments" placeholder="Deixe o seu comentario..." aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary botao" type="submit">Enviar</button>
                    </div>
                </form>
                
                
        </div>
            
        @endforeach
    
</div>




 --}}

@endsection