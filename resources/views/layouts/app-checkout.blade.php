<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://geowidget.inpost.pl/inpost-geowidget.css" />
    <script src="https://geowidget.inpost.pl/inpost-geowidget.js" defer></script>

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
                    <div class="nav-desktop d-flex align-items-center justify-content-end w-100">
                        {{-- Licznik odwiedzin (desktop) --}}
                        <div class="visitor-counter fw-bold me-3">
                            👥 Have already visited us <span class="text-primary">{{ $visitorsCount }}</span> people 👥
                        </div>

                        @guest
                            <li class="nav-item dropdown list-unstyled me-3">
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
                            <span class="navbar-brand welcome-user me-3">
                                    Hello there {{ Auth::user()->name }}
                                </span>
                            <li class="nav-item dropdown list-unstyled me-3">
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
                        <li class="nav-item list-unstyled">
                            <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span id="cart-count-badge" class="{{ $cartCount > 0 ? '' : 'd-none' }}">
                                        {{ $cartCount }}
                                    </span>
                            </a>
                        </li>
                    </div>



                    {{-- Mobile: licznik + ikonki --}}
                    <div class="nav-mobile d-md-none d-flex align-items-center justify-content-end gap-3 pe-3">
                        {{-- Licznik odwiedzin uproszczony --}}
                        <div class="visitor-counter fw-bold">
                            👥 {{ $visitorsCount }} 👥
                        </div>

                        @guest
                            <li class="nav-item dropdown list-unstyled">
                                <a id="navbarDropdownMobile" class="nav-link dropdown-toggle p-0" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-user fa-lg"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMobile">
                                    @if (Route::has('login'))
                                        <a class="dropdown-item" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    @endif
                                    @if (Route::has('register'))
                                        <a class="dropdown-item" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    @endif
                                </div>
                            </li>
                        @else
                            <span class="navbar-brand welcome-user d-none">
                                    Hello there {{ Auth::user()->name }}
                                </span>
                            <li class="nav-item dropdown list-unstyled">
                                <a id="navbarDropdownMobile" class="nav-link dropdown-toggle p-0" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-user fa-lg"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMobile">
                                    @can(['isAdmin'])
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    @endcan
                                    <a class="dropdown-item" href="{{ route('myOrders.index') }}">My orders</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest

                        {{-- Koszyk --}}
                        <li class="nav-item list-unstyled">
                            <a class="nav-link position-relative p-0" href="{{ route('cart.index') }}">
                                <i class="fa-solid fa-cart-shopping fa-lg"></i>
                                <span id="cart-count-badge-mobile" class="{{ $cartCount > 0 ? '' : 'd-none' }}">
                                        {{ $cartCount }}
                                    </span>
                            </a>
                        </li>
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

