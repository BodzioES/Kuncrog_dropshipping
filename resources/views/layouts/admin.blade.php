<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite([
    'resources/css/admin.css',
    'resources/css/order.css',
    'resources/js/app.js',
    'resources/js/delete.js',
    ])

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">

    <!-- Ikony -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

@yield('navbar')

<div class="container-fluid">
    <div class="row">
        <!-- Desktop sidebar -->
        <nav class="col-md-2 d-none d-md-block sidebar my-sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{request()->routeIs('admin.dashboard') ? 'active' : ''}}"
                           href="{{route('admin.dashboard')}}">
                            <span data-feather="home"></span>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{request()->routeIs('admin.orders.*') ? 'active' : ''}}"
                           href="{{route('admin.orders.index')}}">
                            <span data-feather="file"></span>
                            Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{request()->routeIs('products.*') ? 'active' : ''}}"
                           href="{{route('products.index')}}">
                            <span data-feather="shopping-cart"></span>
                            Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{request()->routeIs('admin.users.*') ? 'active' : ''}}"
                           href="{{route('admin.users.index')}}">
                            <span data-feather="users"></span>
                            Customers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="bar-chart-2"></span>
                            Reports <i class="fa-solid fa-circle-exclamation" style="color:red;"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="layers"></span>
                            Integrations <i class="fa-solid fa-circle-exclamation" style="color:red;"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{request()->routeIs('admin.visitors.*') ? 'active' : ''}}"
                           href="{{route('admin.visitors.index')}}">
                            <span data-feather="map-pin"></span>
                            Tracking
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Mobile burger -->
        <div class="d-md-none p-2 bg-light border-bottom mobile-navbar">
            <button class="btn btn-outline-primary d-flex align-items-center" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i data-feather="menu"></i> <span class="ms-2">Menu</span>
            </button>
        </div>

        <!-- Offcanvas (mobile sidebar) -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{request()->routeIs('admin.dashboard') ? 'active' : ''}}"
                           href="{{route('admin.dashboard')}}">
                            <span data-feather="home"></span> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{request()->routeIs('admin.orders.*') ? 'active' : ''}}"
                           href="{{route('admin.orders.index')}}">
                            <span data-feather="file"></span> Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{request()->routeIs('products.*') ? 'active' : ''}}"
                           href="{{route('products.index')}}">
                            <span data-feather="shopping-cart"></span> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{request()->routeIs('admin.users.*') ? 'active' : ''}}"
                           href="{{route('admin.users.index')}}">
                            <span data-feather="users"></span> Customers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="bar-chart-2"></span>
                            Reports <i class="fa-solid fa-circle-exclamation" style="color:red;"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="layers"></span>
                            Integrations <i class="fa-solid fa-circle-exclamation" style="color:red;"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{request()->routeIs('admin.visitors.*') ? 'active' : ''}}"
                           href="{{route('admin.visitors.index')}}">
                            <span data-feather="map-pin"></span> Tracking
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            @yield('content')
        </main>
    </div>
</div>

<script>
    // aktywacja feather icons
    document.addEventListener("DOMContentLoaded", function () {
        feather.replace();
    });
</script>

<script type="text/javascript">
    @yield('javascript')
</script>
@yield('js-files')
</body>
</html>
