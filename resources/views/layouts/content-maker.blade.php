<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Щопочитайка') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
            
        @vite(['resources/css/my_style.css', 'resources/js/most_used.js', 'resources/js/content_maker.js'])    
    </head>
<body>
    <img src="{{ asset('images/BG.jpg') }}" alt="" id="bg">
    {{-- <div id="bg"></div> --}}
    <div class="container-fluid">
        <div class="row">
    
        {{-- Меню контент-мейкера --}}
        <header id="header" class="col-lg-2 col-md-3 col-sm-12 p-none">
                <nav>
                    <a class="content-maker-menu-btt" href="/" target="_blank" id="content-maker-title-btt">           
                        {{-- <img src="/images/favicon.png" alt="Щопочитайка" class="logo_img"> --}}
                        <i class="fa-solid fa-angle-left"></i>
                        Щопочитайка
                    </a>
                    <a class="content-maker-menu-btt" href="/content-maker/persons">Персони</a>
                    <a class="content-maker-menu-btt" href="/content-maker/person">Додати персону</a>
                    <a class="content-maker-menu-btt" href="/content-maker/works">Твори</a>
                    <a class="content-maker-menu-btt" href="/content-maker/work">Додати твір</a>
                    <a class="content-maker-menu-btt" href="/content-maker/editions">Видання</a>
                    <a class="content-maker-menu-btt" href="/content-maker/edition">Додати видання</a>
                    <a class="content-maker-menu-btt" href="/content-maker/publishers">Видавництва</a>
                    <a class="content-maker-menu-btt" href="/content-maker/publisher">Додати видавництво</a>
                </nav>
        </header>    

        <div id="app" class="col-lg-10 col-md-9 col-sm-12">
            <main>
                @yield('content')
            </main>
        </div>

        </div>
    </div>

    {{-- <footer class="text-center" id="footer">
        <div class="col">
        </div>
        <address class="col">
            <div>© whattoread.com, 2023</div>
            <div>Авторські права збережено</div>
        </address>
    </footer>  --}}
    <script src="https://kit.fontawesome.com/c04e65d013.js" crossorigin="anonymous"></script>

</body>
</html>