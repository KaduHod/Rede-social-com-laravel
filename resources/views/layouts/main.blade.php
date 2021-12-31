  
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- Styles -->
        <link rel="stylesheet" href="/css/estilos.css">
        <link rel="stylesheet" href="/css/Pub_.css">
        <link rel="stylesheet" href="/css/chat.css">
        <!-- Styles jQuery -->
        <link href="/css/jquery.flexdatalist.min.css" rel="stylesheet" type="text/css">
        <style>
            
        </style>
    </head>
    <body >
    
    <header class="sombraCard">
        <nav class="navbar navbar-expand-lg navbar-ligth">
            <div class="collapse navbar-collapse" id="navbar">
                @if(Auth::user())
                    <a href="/dashboard" class="navbar">
                        <ion-icon name="analytics" style='width:50px;height:50px;color:black'></ion-icon>
                    </a>
                @else
                    <a href="/" class="navbar">
                        <ion-icon name="analytics" style='width:50px;height:50px;color:black'></ion-icon>
                    </a>
                @endif
            </div>
            

            <ul class="navbar-nav" >
            @auth
            <form action="/searchPerfil" method="get">
                <input type="text" name="search" id="search" class='form-control' placeholder='Procurar perfil...'>
            </form>
                @if(Auth::user()->isAdmin == 1)
                    <li class="nav-item">
                            <a href="/tabelaDeUsuarios" class="nav-link">Gerenciar usuarios</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="/createPub" class="nav-link">Publicações</a>
                </li>
                <li class="nav-item">
                    <a href="/chat" class="nav-link">Chat</a>
                </li>
                
                <li class="nav-item">
                    <form action="/logout" method='post' >
                        @csrf 
                        <a href="/logout" class="nav-link" onclick="
                            event.preventDefault();
                            this.closest('form').submit();"
                        >Logout</a>
                    </form>
                </li>
                <li class="nav-item liHeader"  >
                    
                    {{-- @if(count($queryNotifications)>0)
                        <ion-icon id='not' style='width:30px; height: 30px;color:red;' name="apps"></ion-icon>
                    @else
                        <ion-icon id='not' style='width:30px; height: 30px;' name="apps"></ion-icon>
                    @endif --}}
                    <ion-icon id='not' style='width:30px; height: 30px;' name="apps-outline"></ion-icon>
                    
                    
                </li>
                <a href="/profile">
                    <li class="profileArea nav-item" style="
                        background-image:url('/img/profilePictures/{{Auth::user()->image}}')
                    ">
                    </li>
                </a>
                <div class="notificationsBox" id='notifications'>
                    <div id='closeNotBox' style='
                        display:flex;
                        justify-content:flex-end;
                        '><ion-icon style='width:20px;height:20px' name="close"></ion-icon></div>
                    <div class='flexContainerNot'>
                        <h2 style='margin-top:5px'>Notificações</h2>
                        <ul id='listaNot'>
                            {{-- @foreach($queryNotifications as $not)
                                @if($not->visualized < 1)
                                <form action="/visualizarNotificação/{{$not->id}}" style='width:100%' method="get">
                                        <li onclick="this.closest('form').submit()">{{$not->outsiderUserName}}&nbsp;{{$not->msg}}</li>
                                </form>
                                
                                @endif
                            @endforeach --}}
                        </ul>
                        
                    </div>
                    
                </div>
                
            @endauth
            @guest
                <li class="nav-item">
                    <a href="/logar" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a href="/registrar" class="nav-link">Registro</a>
                </li>
                
            @endguest
            </ul>
        </nav>
        
    </header>
    <main class='container-fluid'>
        <div class='row'>
            @if(session('msg'))
                <p class="msg" style='
                    width: 100%;
                    margin-bottom: 5px;
                    padding: 10px;
                    background-color: rgb(170, 206, 170);
                    color: green;
                    text-align: center;
                '>{{session('msg')}}</p>
            @endif
            @yield('content')
        </div>
    </main>
    <footer class="text-center text-lg-start site-footer">
    <!-- Copyright -->
        <div class="text-center p-3 footer sombraCard">
           Rede social © 2020 Copyright:
            
        </div>
    <!-- Copyright -->
    </footer>
    </body>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="/js/jQuery3-6-0/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script src="/js/jquery-flexdatalist-2.3.0/jquery.flexdatalist.min.js">
    <script src="/js/eventsCreatepub.js"></script>
    <script src="/js/eventos.js"></script>
    <script src="/js/curtirDescurtir.js"></script>
    <script src="/js/comentariosPub.js"></script>
    <script src="/js/chat.js"></script>
    
    
    
</html>