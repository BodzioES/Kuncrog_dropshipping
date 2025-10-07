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
        'resources/css/app.css'
        ])

</head>
<body class="d-flex flex-column min-vh-100">


    {{--  Wyswietlenie navbaru o informacji o cookie  --}}
    @include('cookie-banner')

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

                {{-- Menu --}}
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    {{-- Lewa strona --}}
                    <ul class="navbar-nav me-auto"></ul>

                    {{-- Licznik odwiedzin (desktop) --}}
                    <div class="visitor-counter fw-bold">
                        👥 Have already visited us <span class="text-primary">{{ $visitorsCount }}</span> people 👥
                    </div>

                    {{-- Prawa strona --}}
                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-user"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if (Route::has('login'))
                                        <a class="dropdown-item" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    @endif
                                    @if (Route::has('register'))
                                        <a class="dropdown-item" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    @endif
                                </div>
                            </li>
                        @else
                            <span class="navbar-brand welcome-user d-none d-md-inline">
                                Hello there {{ Auth::user()->name }}
                            </span>
                            <li class="nav-item dropdown">
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
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest

                        {{-- Koszyk --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span id="cart-count-badge" class="{{ $cartCount > 0 ? '' : 'd-none' }}">
                                    {{ $cartCount }}
                                </span>
                            </a>
                        </li>
                    </ul>

                    {{-- Mobile: licznik + ikonki --}}
                    <div class="nav-mobile d-md-none">
                        <div class="visitor-counter fw-bold text-center mb-3">
                            👥 Have already visited us <span class="text-primary">{{ $visitorsCount }}</span> people 👥
                        </div>

                        <div class="nav-icons">
                            <a id="mobileUser" class="nav-link" href="#">
                                <i class="fa-solid fa-user fa-lg"></i>
                            </a>
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="fa-solid fa-cart-shopping fa-lg"></i>
                                <span id="cart-count-badge-mobile" class="{{ $cartCount > 0 ? '' : 'd-none' }}">
                                    {{ $cartCount }}
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <main class="py-4 flex-grow-1">
            @yield('content')
        </main>
    </div>

    <script type="text/javascript">
        @yield('javascript')
    </script>
    @yield('js-files')
    @vite('resources/js/cookie-navbar.js')

    </body>
</html>

