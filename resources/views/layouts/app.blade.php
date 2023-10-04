<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title)? $title:'' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    @vite(['resources/css/my_style.css', 'resources/js/most_used.js', 'resources/js/client.js'])   
</head>
<body>

    <img src="{{ asset('images/BG.jpg') }}" alt="" id="bg">

    <header id="header">
        <div class="container">
            <div class="row">
    
                <nav class="navbar navbar-expand-lg bg-transparent m-none">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        
                            <a class="navbar-brand" href="/"><h1>Щопочитайка</h1></a>
    
                            <form action="" class="d-flex me-2" role="search" method="GET">
                                <input class="base-input me-2" type="search" name="name" placeholder="Пошук" aria-label="Search">
                                <button class="base-btn" type="submit">Пошук</button>
                            </form>
    
                            @guest
                                @if (Route::has('login'))
                                    <a class="nav-link me-2" href="{{ route('login') }}">Вхід</a>
                                @endif
    
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">Рестрація</a>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <span class="ava">{{ Auth::user()->name[0] }}</span>
                                    </a>
                                        <div class="custom-dropdown-menu dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="/profile">Профіль</a>                                            </a>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
        
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                </li>
                            @endguest
                        </div>
                    </div>
                </nav>

                <div  class="side-navbar-container">
                    <nav  class="side-navbar">
                        <a href="/"><i class="fa-solid fa-house"></i></a> {{-- Головна --}}
                        <a href="/items"><i class="fa-solid fa-scroll"></i></a> {{-- Товари --}}
                        <a href="/profile"><i class="fa-solid fa-user"></i></a> {{-- Профіль --}}
                    </nav>
                </div>
                          
            </div>
        </div>
    </header>    

    <div id="app" class="container py-4">
        <div class="row">
            <aside class="col-lg-3 col-md-6 col-sm-12 pe-5">
                @yield('aside')
            </aside>
            <main class="col-lg-9 col-md-6 col-sm-12">
                @yield('content')
            </main>
        </div>

    </div>

    {{-- <footer class="text-center" id="footer">
        <address class="col">
            <div>© whattoread.com, 2023</div>
            <div>Авторські права збережено</div>
        </address>
    </footer>  --}}

    <script src="https://kit.fontawesome.com/c04e65d013.js" crossorigin="anonymous"></script>
    
</body>
</html>