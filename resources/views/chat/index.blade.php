@extends('layouts.main')

@section('title','Crud')
@section('content')
<script>
    userObj = {}
</script>
<div class="container">
    
    <div id="leftSideChat">
        <ul id="leftSideChatOptions">
            
            <li>
                <ion-icon id="chats" class="iconeLeftSideChat white2" name="chatbubbles"></ion-icon>
            </li>
            <li>
                <ion-icon id="followers" class="iconeLeftSideChat" name="people"></ion-icon>
            </li>
        </ul>
        <div id="leftSideChatContainers">
            <ul id="boxChats" class="option">
                @foreach ($chats as $chat)
                
                        @if($chat->users[0]->name == Auth::user()->name)
                            <li class="chatUsersOption" id="chat-{{$chat->users[1]->name}}-{{$chat->users[1]->id}}-{{$chat->id}}">
                                <div class="chatUserProfilePic"  style="background-image: url('/img/profilePictures/{{$chat->users[1]->image}}')">
                                </div>
                                <div class="chatUsersNameLastText" >
                                    <div class="chatUsersName">
                                        <a href="/outsiderProfile/{{$chat->users[1]->id}}">{{$chat->users[1]->name}}</a>
                                            
                                    </div>
                                    <div class="chatUsersLastText">
                                        @php
                                            $ultimaMensagem = count($chat->messages);
                                            
                                            $new_date = new DateTime($chat->messages[$ultimaMensagem -1]->created_at) ;
                                            $dataFormatada = $new_date->format('d/m/y - H:i')  ;
            
                                        @endphp
                                        <p class=''><span class="ultimaMensagem" >- {{$chat->messages[$ultimaMensagem - 1]->message}}</span> <span class="date"> {{$dataFormatada}} </span></p>{{--quai tem um erro--}}
                                    </div>
                                </div>
                                
                               <script>//separo mensagens do user
                                    
                                    attrObj = {!! json_encode($chat->users[1]->name) !!}
                                    


                                    function user(){
                                        obj = {
                                            'guestInfo':{!! json_encode($chat->users[1]->toArray()) !!},
                                            'mensagensDoChat':{!! json_encode($chat->messages->toArray()) !!},
                                            //'chat_id':{!! json_encode($chat->users[1]->chats)!!}
                                        }


                                        return obj
                                    }


                                    userObj[attrObj] = user() 
                                </script>
                            </li>
                        @else
                            <li class="chatUsersOption" id="chat-{{$chat->users[0]->name}}-{{$chat->users[0]->id}}-{{$chat->id}}">
                                <div class="chatUserProfilePic"  style="background-image: url('/img/profilePictures/{{$chat->users[0]->image}}')">
                                </div>
                                <div class="chatUsersNameLastText" >
                                    <div class="chatUsersName">
                                        <a href="/outsiderProfile/{{$chat->users[0]->id}}">{{$chat->users[0]->name}}</a>
                                            
                                    </div>
                                    <div class="chatUsersLastText">
                                        @php
                                            $ultimaMensagem = count($chat->messages);
                                            $new_date = new DateTime($chat->messages[$ultimaMensagem - 1]->created_at) ;
                                            $dataFormatada = $new_date->format('d/m/y - H:i')  ;
                                        @endphp
                                        <p class=''><span class="ultimaMensagem">- {{$chat->messages[$ultimaMensagem - 1]->message}}</span>  <span class="date">{{$dataFormatada}}</span></p>
                                    </div>
                                </div>
                                
                                
                                <script>//separo mensagens do user
                                    
                                    attrObj = {!! json_encode($chat->users[0]->name) !!}
                                    
                                    function user(){
                                        obj = {
                                            'guestInfo':{!! json_encode($chat->users[0]->toArray()) !!},
                                            'mensagensDoChat':{!! json_encode($chat->messages->toArray()) !!},
                                            //'chat_id':{!! json_encode($chat->users[0]->chats)!!}
                                        }
                                        return obj
                                    }
                                    userObj[attrObj] = user() 
                                </script>
                            </li>
                        @endif 
                        
                    
                @endforeach
            </ul>
            <ul id="boxFollowers" class="option none">
                @foreach(Auth::user()->following as $following)
                    @php
                    
                    // pego o id do chat correto atraves do pivot table e following user
                    $chatCerto = null;
                    foreach ($following->chats as $chat) {
                        if ($chat->pivot->user_id == $following->id) {
                            $chatCerto = $chat->id;
                        } 
                    }
                    
                    
                                    
                    @endphp
                    <li class="chatUsersOption" id="follower-{{$following->name}}-{{$following->id}}-{{$chatCerto}}">
                        <div class="chatUserProfilePic"  style="background-image: url('/img/profilePictures/{{$following->image}}')">
                        </div>
                        <div class="chatUsersNameLastText" style="padding: 0">
                            <div class="chatUsersName">
                                <a href="/outsiderProfile/{{$following->id}}">{{$following->name}}</a>
                                    
                            </div>
                        </div>
                    </li>
                    @foreach (Auth::user()->following as $following)
                    <script>
                        if(!userObj.hasOwnProperty({!! json_encode($following->name) !!})){
                            attrObj = {!! json_encode($following->name) !!}
                            
                            function user(){
                                obj = {
                                    'guestInfo':{!! json_encode($following) !!},
                                    'mensagensDoChat':[],
                                    //'chat_id':{!! json_encode($following->chats)!!}
                                    
                                }
                                return obj
                            }
                            userObj[attrObj] = user()
                        }
                        
                    </script>
                    @endforeach
                    
                @endforeach
            </ul>
        </div>
    </div> 
    
   
    
    <div class="textContainer">
        
        @if(count(Auth::user()->chats) > 0)
        
            <div class="infoConversation">
                <div class="chatUserProfilePic" id="chatUserProfilePic" style="background-image: url('/img/profilePictures/{{$chatPadrao['guestUser']->image}} ')">
                </div>
                <h6 class="nomeUser" id="nomeUser">{{$chatPadrao['guestUser']->name}}</h6>
                <ion-icon name="build-outline"></ion-icon>
            </div>
            <ul class="textsCoversation">
                @foreach ($chatPadrao['mensagens'] as $msg)
                    @if($msg->user_id == Auth::user()->id)
                        <li class="msgTextConversation shadow  userMSG">
                            {{$msg->message}}
                        </li>
                    @else
                        <li class="msgTextConversation shadow  guestMSG">
                            {{$msg->message}} 
                        </li>
                    @endif
                @endforeach
                
                
            </ul>
        @else
        
            @if(count(Auth::user()->following) > 0 )
                <div class="infoConversation">
                    <div class="chatUserProfilePic" id="chatUserProfilePic" style="background-image: url('/img/profilePictures/{{Auth::user()->following[0]->image}} ')">
                    </div>
                    <h6 class="nomeUser" id="nomeUser">{{Auth::user()->following[0]->name}}</h6>
                    <ion-icon name="build-outline"></ion-icon>
                </div>
                <div class="textsCoversation">
                    nenhuma mensagem ainda
                </div>
            @else{{--Caso user não tenho nao siga ninguem--}}
                <div class="infoConversation">
                    <div class="chatUserProfilePic" id="chatUserProfilePic" style="background-image: url('/img/profilePictures/{{--Auth::user()->following[0]->image--}} ')">
                    </div>
                    <h6 class="nomeUser" id="nomeUser">{{--Auth::user()->following[0]->name--}}</h6>
                    <ion-icon name="build-outline"></ion-icon>
                </div>
                <div class="textsCoversation">
                    nenhuma mensagem ainda
                </div>

            @endif
            
        @endif
        
        <form class="sendBox" id="formSandMassage" method="post" action="/chat/postMassage">
            @csrf
            <input type="hidden" id="chat_id" name="chat_id" value="{{$chatPadrao['chat']}}">
            <input type="hidden" id="guest_id" name="guest_id" value='{{$chatPadrao['guestUser']->id}}'>
            <input type="text" name="sandMassage" class="chatInput form-control">
            <button type="submit" class="btn  botaoChat">Enviar</button>
        </form>
    </div>
</div>
@endsection