<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite([
            'resources/sass/app.scss',
            'resources/js/app.js',
            'resources/css/app.css',
        ])

</head>

    <body class="d-flex flex-column min-vh-100">

        {{--  Wyswietlenie navbaru o informacji o cookie  --}}
        @include('cookie-banner')

        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <div class="row justify-content-center text-center">
                INFO: the webstore is in progress so a few things might be not working or bad working
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>

        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    {{-- Logo --}}
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>

                    {{-- Burger --}}
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    {{-- Desktop Navbar --}}
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto d-none d-md-flex">
                            {{-- miejsce na inne linki po lewej --}}
                        </ul>

                        {{-- Desktop: licznik + user + koszyk --}}
                        <div class="d-none d-md-flex align-items-center ms-auto">
                            {{-- Licznik odwiedzin --}}
                            <div class="visitor-counter me-3">
                                <strong>👥 Have already visited us <span class="text-primary">{{ $visitorsCount }}</span> people 👥</strong>
                            </div>

                            {{-- User dropdown --}}
                            <div class="nav-item dropdown me-3">
                                @guest
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        @if (Route::has('login'))
                                            <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                                        @endif
                                        @if (Route::has('register'))
                                            <a class="dropdown-item" href="{{ route('register') }}">Register</a>
                                        @endif
                                    </div>
                                @else
                                    <span class="navbar-brand welcome-user me-2">
                                Hello {{ Auth::user()->name }}
                            </span>
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        @can(['isAdmin'])
                                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                        @endcan
                                        <a class="dropdown-item" href="{{ route('myOrders.index') }}">My orders</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                @endguest
                            </div>

                            {{-- Koszyk --}}
                            <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                                <i class="fa-solid fa-cart-shopping fa-lg"></i>
                                <span id="cart-count-badge" class="{{ $cartCount > 0 ? '' : 'd-none' }}">
                            {{ $cartCount }}
                        </span>
                            </a>
                        </div>

                        {{-- Mobile Navbar --}}
                        <div class="d-flex d-md-none align-items-center ms-auto">
                            {{-- Licznik --}}
                            <div class="visitor-counter me-3 text-center">
                                <span class="visitor-text">
                                    👥 <span class="d-none d-sm-inline">Have already visited us</span>
                                    <span class="text-primary fw-bold">{{ $visitorsCount }}</span>
                                    <span class="d-none d-sm-inline">people</span> 👥
                                </span>
                            </div>

                            {{-- Mobile user dropdown --}}
                            <div class="dropdown me-3">
                                <a id="mobileUser" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-user fa-lg"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="mobileUser">
                                    @guest
                                        @if (Route::has('login'))
                                            <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                                        @endif
                                        @if (Route::has('register'))
                                            <a class="dropdown-item" href="{{ route('register') }}">Register</a>
                                        @endif
                                    @else
                                        @can(['isAdmin'])
                                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                        @endcan
                                        <a class="dropdown-item" href="{{ route('myOrders.index') }}">My orders</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    @endguest
                                </div>
                            </div>

                            {{-- Koszyk --}}
                            <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                                <i class="fa-solid fa-cart-shopping fa-lg"></i>
                                <span id="cart-count-badge-mobile" class="{{ $cartCount > 0 ? '' : 'd-none' }}">
                            {{ $cartCount }}
                        </span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="py-4 flex-grow-1">
                @yield('content')
            </main>

        </div>

        <footer class="bg-body-tertiary text-center mt-auto">
            <div class="container pt-4">
                <section class="mb-4 ">
                    <a class="btn btn-link btn-floating btn-lg text-body m-1" target="_blank" href="https://www.facebook.com/profile.php?id=100017190855716"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-link btn-floating btn-lg text-body m-1" target="_blank" href="https://www.linkedin.com/in/albert-rogozinski-505777270/"><i class="fab fa-linkedin"></i></a>
                    <a class="btn btn-link btn-floating btn-lg text-body m-1" target="_blank" href="https://media.tenor.com/WuOwfnsLcfYAAAAC/star-wars-obi-wan-kenobi.gif"><i class="fab fa-google"></i></a>
                    <a class="btn btn-link btn-floating btn-lg text-body m-1" target="_blank" href="https://www.instagram.com/albert_rogoz/#"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-link btn-floating btn-lg text-body m-1" target="_blank" href="https://github.com/BodzioES"><i class="fab fa-github"></i></a>
                </section>
            </div>
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                © 2025 Copyright:
                <a class="text-body" href="#">Kuncrog</a>
            </div>
        </footer>
        <script type="text/javascript">
            @yield('javascript')
        </script>
        @yield('js-files')
        @vite('resources/js/cookie-navbar.js')
    </body>
</html>

