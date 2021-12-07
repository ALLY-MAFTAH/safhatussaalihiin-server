<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('', 'Safhatussaalihiin Server App') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .card-header {
            color: white;
            width: 100%;
            text-align: center;
            font-weight: 900;
            font-size: 18px;
            background: rgb(51, 35, 1)
        }

        .card-body {
            background: rgba(207, 166, 77, 0.459);
            width: auto;
            width: 100%;
        }

        h3 {
            text-align: center;
            color: rgb(12, 3, 34);
            text-align: center;
            font-weight: 900;
            padding-top: 70px;
            padding-bottom: 10px;
        }

        h4 {
            padding-top: 20px;
            font-size: 30px
        }

        .music-icon {
            color: rgb(224, 116, 15);
            font-size: 25px;
        }

        .theader {
            text-align: center;
            background-color: rgb(240, 225, 191);
            font-size: 30px;
            color: rgb(136, 78, 12);
            padding: 10px;
        }

        .nav-items-2 {
            justify-content: center;
            color: rgb(107, 50, 3);
            text-shadow: 2px 2px 4px #e8e7f3;
            font-weight: 900;

        }

        .nav-items-2:hover {
            color: #fff;
        }

        .active {
            color: rgb(19, 7, 130) !important;
            text-underline-position: below;
            text-shadow: 4px 4px 6px #f1f1f5;
            font-weight: 900;
            /* font-style: italic; */
            border-bottom: 3px solid;
        }

        .zoom {
            transition: transform .2s;
        }

        .zoom:hover {
            transform: scale(1.1);
            /* (130% zoom) */
        }

        .zoom-image {
            transition: transform .2s;
        }

        .zoom-image:hover {
            transform: scale(9.3);
            /* (130% zoom) */
        }

    </style>
</head>

<body>
    <div id="app">
        <nav id="navbar_top" class="navbar navbar-expand-md navbar-light shadow-lg"
            style=" background-color: rgb(223, 194, 134)">
            <div class="container">
                <a href="{{ route('home') }}"> <img src="{{ asset('/assets/logo/safhatussaalihiin.png') }}"
                        height="60px"></a>
                @guest

                    <h2 style="padding-left: 30px; color: rgb(136, 79, 4); font-weight:bolder">SAFHATU SSAALIHIIN</h2>
                @endguest

                <button class="navbar-toggler" style="background-color: rgb(163, 101, 7)" type="button"
                    data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @guest
                        @if (Route::has('login'))
                            <div></div>
                        @endif

                        @if (Route::has('register'))
                            <div></div>
                        @endif
                    @else
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item list-unstyled">
                                <a class="nav-link " href="{{ route('home') }}">
                                    <h5 class="nav-items-2 {{ request()->routeIs('home') ? 'active' : '' }}"> Home
                                    </h5>
                                </a>
                            </li>
                            <li class="nav-item  list-unstyled">
                                <a class="nav-link " href="{{ route('media') }}">
                                    <h5
                                        class="nav-items-2 {{ request()->routeIs('media') || request()->routeIs('year') || request()->routeIs('month') || request()->routeIs('pictures') || request()->routeIs('videos') ? 'active' : '' }}">
                                        Posts</h5>
                                </a>
                            </li>
                            <li class="nav-item  list-unstyled">
                                <a class="nav-link " href="{{ route('live_stream') }}">
                                    <h5 class="nav-items-2 {{ request()->routeIs('live_stream') ? 'active' : '' }}">
                                        Radios</h5>
                                </a>
                            </li>
                        </ul>
                    @endguest

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a style="color: blue; font-size: 17px" id="navbarDropdown" class="nav-link dropdown-toggle"
                                    href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a style="color: red" class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                                                         document.getElementById('logout-form').submit();">
                                        <i class="fas fa-power-off"></i>{{ __(' Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>

                                    <a style="color: rgb(241, 10, 10)" class="dropdown-item" href="#"
                                        onclick="event.preventDefault(); document.getElementById('change-password-form').submit();">
                                        <i class="fas fa-key"></i> {{ __('Change Password') }}
                                    </a>

                                    <form id="change-password-form" action="{{ route('change_password') }}" method="GET"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            <div class="row">
                @yield('content')
            </div>
        </main>
        <!--FOOTER  -->
        <footer id="main-footer" class="bg-light text-dark mb-3">
            <div class="container">
                <div class="col">
                    <hr>
                    <p class="lead text-center">
                        &copy; <span id="year"></span> Safhatussaalihiin
                    </p>
                </div>
            </div>
        </footer>
    </div>
    <script>
        // Get the current year for the copyright
        $('#year').text(new Date().getFullYear());

        CKEDITOR.replace('editor1');
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.addEventListener('scroll', function() {
                if (window.scrollY > 1) {
                    document.getElementById('navbar_top').classList.add('fixed-top');
                    // add padding top to show content behind navbar
                    navbar_height = document.querySelector('.navbar').offsetHeight;
                    document.body.style.paddingTop = navbar_height + 'px';
                } else {
                    document.getElementById('navbar_top').classList.remove('fixed-top');
                    // remove padding top from body
                    document.body.style.paddingTop = '0';
                }
            });
        });
    </script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="/__/firebase/8.8.1/firebase-app.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="/__/firebase/8.8.1/firebase-analytics.js"></script>

    <!-- Initialize Firebase -->
    <script src="/__/firebase/init.js"></script>
    @yield('scripts')
</body>

</html>
