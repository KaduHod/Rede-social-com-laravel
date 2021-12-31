@extends('layouts.main')

@section('title','Crud')
@section('content')

<div class="PubShowContainer">
    <div class="PubCard sombraCard">
        <img src="/img/pubPictures/{{$pub->image}}" --}} id="PubCardImage">

    <div id="PubInformações">
        <div id="PubUserNameImages">
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
            {{-- <div class="pubUserPic" style="margin-left:15px;background-image: url('/img/profilePictures/{{$pub->user->image}}">  
            </div> --}}
            <img class="pubUserPic" src="/img/profilePictures/{{$pub->user->image}}" style="object-fit:cover" alt="">
        </div>

        <div id="PubTagsDescription" >
            @php
                $new_date = new DateTime($pub->created_at) ;
                $dataFormatada = $new_date->format('d/m/y - H:i')  ;
            @endphp
            <div class="date" style="margin-bottom: 0px ">
                {{$dataFormatada}}
            </div>
            @if($pub->tags)
                <p>{{$pub->tags}}</p>
            @endif
        </div >
        <div class="PubCommentSection">
            @foreach($pub->comments as $coment)
                <div class="PubComment">
                    <div class="PubCommentPic" style="background-image:url('/img/profilePictures/{{$coment->user->image}}')"></div>
                    <div class="PubCommentInfo">
                        @php
                            $new_date = new DateTime($coment->created_at) ;
                            $dataFormatada = $new_date->format('d/m/y - H:i')  ;
                        @endphp
                        <div class="PubCommentInfoNameDate "> <a href="/outsiderProfile/">{{$coment->user->name}}</a>  <span class="date" >{{$dataFormatada}}</span> </div>
                        <div class="PubCommentInfoComentario">
                            {{$coment->coment}}
                        </div>
                        
                    </div>

                </div>
            @endforeach
            
        </div> 
        <div class="likeShareComment">
            <div class="like">
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
            
                <form action='/coment' method="post" class="input-group  ">
                    @csrf
                    <input type="text" class="form-control inputComments" name='Comentario' placeholder="Deixe o seu comentario..." aria-describedby="basic-addon2">
                    <input type="hidden" name='idPub' value={{$pub->id}}>
                    <div class="input-group-append">
                          <input type='submit' class="btn btn-outline-secondary " style="border-radius:0px; height:60px" value='Enviar' >              
                    </div>
                </form>
            
            
        </div>
        
    </div>
</div>

@endsection