<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>

    @vite(['resources/css/admin.css', 'resources/js/admin.js'])

    @yield('head')
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <!-- Sidebar content -->
        </nav>

        <!-- MAIN CONTENT -->
        <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            @yield('content')
        </main>
    </div>
</div>

@yield('js')
</body>
</html>
