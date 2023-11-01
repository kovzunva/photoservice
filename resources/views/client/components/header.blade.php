<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>{{ $title }}</title> --}}
    <title>Щопочитайка</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/styles.css">		
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600&family=Montserrat+Alternates:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>
<header id="header">
    <div class="container">
        <div class="row">
            
            {{-- <div class="col-lg-4 col-md-6 col-sm-12">        
                <a class="navbar-brand" href="/">           
                    <img src="/images/Title.png" alt="Щопочитайка" class="title_img">
                </a>
            </div> --}}

            {{-- <nav class="navbar navbar-expand-lg col-lg-8 col-md-6 col-sm-12 mt-3" data-bs-theme="dark">
                <div class="container-fluid">
                    
                    <a class="navbar-brand" href="/"><h1>Щопочитайка</h1></a>

                    <a class="navbar-brand" href="/avtors">Автори</a>

                    <form action="" class="d-flex" role="search" method="GET">
                        <input class="form-control me-2" type="search" name="name" placeholder="Пошук" aria-label="Search">
                        <button class="btn btn-outline-success my-btn-static" type="submit">Пошук</button>
                    </form>
                    
                </div>
            </nav> --}}

            <nav class="navbar navbar-expand-lg bg-transparent m-none">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    {{-- <ul class="navbar-nav">
                        <li class="nav-item">
                        <a class="nav-link" href="#">Пункт 1</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Пункт 2</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Пункт 3</a>
                        </li>
                    </ul> --}}
                        <a class="navbar-brand" href="/"><h1>Щопочитайка</h1></a>

                        <a class="navbar-brand" href="/avtors">Автори</a>

                        <form action="" class="d-flex me-2" role="search" method="GET">
                            <input class="base-input me-2" type="search" name="name" placeholder="Пошук" aria-label="Search">
                            <button class="base-btn" type="submit">Пошук</button>
                        </form>

                        @guest
                            @if (Route::has('login'))
                                <a class="nav-link me-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @endif

                            @if (Route::has('register'))
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
                      
        </div>
    </div>
</header>


{{-- <a class="navbar-brand" href="#footer"><i class="fa-solid fa-angles-down"></i></a> --}}