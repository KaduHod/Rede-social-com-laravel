  
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
        <link rel="stylesheet" href="/css/pub.css">
        <link rel="stylesheet" href="/css/Chat.css">
        <link rel="stylesheet" href="/css/prof.css">
        <!-- Styles jQuery -->
        <link href="/css/jquery.flexdatalist.min.css" rel="stylesheet" type="text/css">
        <style>
            .row{
                background-image: url("/img/layoutPictures/backgroundPadraoSite.jpg");
                background-attachment: fixed;
                background-position: center;
                background-size: cover;
            }
            #logo{
                max-width: 70px;
                max-height: 70px;
                object-fit: fill;
                position: absolute;
                display: block;
                margin: 0;
                top: -5px;
                transition: 300ms;
                right: -150px;
                
                
            }
            
            .menu{
                width:17vw;
                height: 10vh;
                top: -2px;
                height: 00vh;                
                display: block;
                right:  0;
                border-radius: 50px;
                
                position: absolute;
                z-index: 99990;
                
                
                
            }
            
            .menu:hover #logo{
                transform: scale(2.5);
                top: 50px;
                z-index: 99999;
                
            }
            .menu:hover{
                width: 17vw;
            }
            .menuContainerFlex{
                display: flex;
                width:100%;
                height: 100%;
            }
            .menuContainerFlex ul{
                animation: logo 200ms cubic-bezier(0.175, 0.885, 0.32, 1.275)  1 forwards ;
                position: absolute;
                display: block;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-end;
                list-style: none;
                border-radius: 0.25em;
                padding: 10px;
                top: -500px;
                transition:  200ms ;
                margin-top:40px; 
            }
            .menuContainerFlex:hover  ul{                
                width: 100%;
                top: 100px;
                
            }
            .menuContainerFlex  a{
                color: #310202;
            }
            
            
            
            .menuContainerFlex:hover  li{
                
                background-color: white;
                color: #310202;
                list-style: none;
                border-radius: 100px;
                padding: 3px;
                margin-top:10px;
                padding: 0;
                max-width: fit-content;
                min-width: fit-content;
                
            }
            /* .menuContainerFlex:hover  ul{
                list-style: none;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center
                
            } */
            @keyframes logo {
                10%{
                    width:17vw;
                    background-color:rgb(255, 255, 255);
                    border: 1px solid rgb(196, 196, 196); 
                }
                100%{
                    width: 17vw;
                    height: fit-content;
                    
                    background-color:rgb(255, 255, 255);
                    border: 1px solid rgb(196, 196, 196);   
                    
                }
            }
            .liMenu{
                display: flex;
                align-items: center;
                justify-content: space-around;
                padding-left: 10px;
            }
            .liMenu a{
                flex: 1;
                transition: 400ms;
                padding: 0;
                margin-left: 5px;
            }
            .liMenu  a:hover{
                color: #310202;
            }
            
            
            .liMenu ion-icon{
                
                width: 20px;
                height: 20px;
            }
            .navbar-nav{
                width: 58%;
                justify-content: space-between;
            }
            
        </style>
    </head>
    <body >
        
    <header class="border_bottom">
        <nav class="navbar navbar-expand-lg ">
            
            
            
           
            <div class="menu">
                <div class="menuContainerFlex">
                    <a href="/dashboard" class="navbar">
                        <img src="/img/logo/logo_vermelha2.0.png" id='logo'alt="">
                    </a>
                    <ul>
                        @auth
                        @if(Auth::user()->isAdmin == 1)
                        <li class="nav-item liMenu">
                            <ion-icon name="people"></ion-icon>
                            <a href="/tabelaDeUsuarios" class="nav-link">Gerenciar usuarios</a>
                        </li>
                        @endif
                        <li class="nav-item liMenu">
                            <ion-icon name="image"></ion-icon>
                            <a href="/createPub" class="nav-link">Publicações</a>
                        </li>
                        <li class="nav-item liMenu">
                            <ion-icon name="chatbubbles"></ion-icon>
                            <a href="/chat" class="nav-link">Chat</a>
                        </li>
                        <li class="nav-item liMenu">
                            <ion-icon name="log-out"></ion-icon>
                            <form action="/logout" method='post' >
                                @csrf 
                                
                                <a href="/logout" class="nav-link" onclick="
                                    event.preventDefault();
                                    this.closest('form').submit();"
                                >Logout</a>
                            </form>
                        </li>
                        
                        @endauth
                        
                        @guest
                            <li class="nav-item liMenu">
                                <ion-icon name="log-in"></ion-icon>
                                <a href="/logar" class="nav-link">Login</a>
                            </li>
                            <li class="nav-item liMenu">
                                <ion-icon name="construct"></ion-icon>
                                <a href="/registrar" class="nav-link">Registro</a>
                            </li>
                            
                        @endguest
                    </ul>
                </div>
                
            </div>
            <ul class="navbar-nav" >
                @auth
                <a href="/profile" >
                    <li class="profileArea nav-item" style="
                        background-image:url('/img/profilePictures/{{Auth::user()->image}}')
                    ">
                    </li>
                    
                </a> 
                    <form action="/searchPerfil" method="get">
                    <input type="text" name="search" id="search" class='form-control' placeholder='Procurar perfil...'>
                    </form>
                    
                @endauth
                
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
    <script src="/js/slider.js"></script>
    
    
    
</html>