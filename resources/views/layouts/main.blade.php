  
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
        

        <style>
            
        </style>
    </head>
    <body >
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <header>
        <nav class="navbar navbar-expand-lg navbar-ligth">
            <div class="collapse navbar-collapse" id="navbar">
                <a href="/" class="navbar">
                    <ion-icon name="analytics" style='width:50px;height:50px;color:black'></ion-icon>
                </a>
            </div>
            <form action="/searchPerfil" method="get">
                <input type="text" name="search" id="search" class='form-control' placeholder='Procurar perfil...'>
            </form>

            <ul class="navbar-nav">
            @auth
                @if(Auth::user()->isAdmin == 1)
                    <li class="nav-item">
                            <a href="/tabelaDeUsuarios" class="nav-link">Gerenciar usuarios</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="/tabelaDeUsuarios" class="nav-link">Publicações</a>
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
                <a href="/tabelaDeUsuarios/editUser/{{Auth::user()->id}}">
                <li class="profileArea nav-item" style="
                    background-image:url('/img/profilePictures/{{Auth::user()->image}}')
                
                ">
                </li>
                </a>
                
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
        <div class="row">
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
         <footer>
            <div id='footerWrapper'>
                <p>Crud &copy; 2021</p>
            </div>
            
        </footer> 
    </body>
</html>