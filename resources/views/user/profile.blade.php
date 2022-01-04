@extends('layouts.main')

@section('title','Crud')
@section('content')
<div id="profile_top">

</div>
 <div  id='profileTop2' class="">
     <div id="backgroundArea" style="background-image: url('/img/slider/1.jpg');" >
        <div id="next">
            <ion-icon class='iconeSlider' name="caret-back-outline"></ion-icon>
        </div>
        <div id="previous">
            <ion-icon  class='iconeSlider' name="caret-forward-outline" ></ion-icon>
        </div>
     </div>
    <div id="userInfo">
        <div id="UserPhoto" style="background-image: url('/img/profilePictures/{{Auth::user()->image}}')">

        </div>
        
        <div id="UserNameDescription" >
            <h3 class="m-b-0">{{Auth::user()->Nome_Completo}}</h3>
            <div id="Description">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus eligendi, porro consectetur sed tempore alias perferendis aut suscipit et? Modi, molestiae voluptate. Consequatur culpa quam optio modi corrupti doloribus vitae.
            </div>
            <div id="buttonsProfile">
                <a style=' color:white' class=' btnProfile' href="/editUser/{{Auth::user()->id}}"> Editar perfil   </a>
                <a class='btnProfile' style=' color:white' id='criarPub' href="/createPub/">
                    Criar publicação 
                </a>
            </div>
        </div>
        <div id="infoProfile">
            <a id='follows' class="infoProfileArea" >{{Auth::user()->followers()->count()}}  <span> Seguidores</span></a>
            <a id='followers' class="infoProfileArea"> {{Auth::user()->following()->count()}} <span>Seguindo</span> </a>
            <span class="infoProfileArea"> {{Auth::user()->publicacao->count()}} <span>Publicações</span></span>
        </div>
    </div>
    
</div> 




<div class="notificationsBox" id='followsBox'>
    <div id='closeFollowsBox' style='display:flex;justify-content:flex-end;'>
        <ion-icon style='width:20px;height:20px' name="close"></ion-icon>
    </div>
    <div class='flexContainerNot'>
        <h2 style='margin-top:5px'>Seguidores</h2>
        <ul id='listaNot'>
        @foreach($Followers as $follower)
            <li><div class='indexBox'>&nbsp;{{$loop->index + 1}}</div>   <a class='linkUser' href="/outsiderProfile/{{$follower->id}}">&nbsp; <div class='linkUserProfilePicture ' style='background-image:url(/img/profilePictures/{{$follower->image}})'></div> {{$follower->name}}</a>   </li>
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
       @foreach($Following as $follow)
            
            <li><div class='indexBox'>&nbsp;{{$loop->index + 1}}</div><a class='linkUser' href="/outsiderProfile/{{$follow->id}}"> &nbsp; <div class='linkUserProfilePicture' style='background-image:url(/img/profilePictures/{{$follow->image}})'></div> {{$follow->name}}</a>   </li>
        @endforeach
        </ul>              
    </div>           
</div>
<div id="pubLogoContainer">
    <div id="pubLogo">
        <ion-icon id="pubLogoIcon" name="layers-outline">
    </div>
    
</ion-icon></div>
<div id="pubContainer" >
    
    @foreach(Auth::user()->publicacao as $pub)
    <div class="card cardPub">
        <div class="pubUserInfo">
            <div class="pubUserPic" style="background-image: url('/img/profilePictures/{{Auth::user()->image}}"> 
                
            </div>
            <div class='pubUserInfoUserName'>
            <a class='' href="/outsiderProfile/{{Auth::user()->id}}">{{Auth::user()->name}}</a>
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
                <ion-icon class="icone iconeComentarios" name="create-outline" id='{{$pub->id}}'></ion-icon>
                <div class="countBox">{{count($pub->comments)}} </div>
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
                                    <a class='comentIcon'  href="/editComent/{{$pub->id}}/{{$comment->id}}">Excluir</a>
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