@extends('layouts.admin')

@section('content')


    <nav class="custom-navbar">
        <div class="custom-container">
            <!-- lewa strona -->
            <h1 class="custom-title">Dashboard</h1>

            <!-- prawa strona -->
            <div class="custom-actions">
                <form class="custom-search-form" role="search">
                    <input class="custom-search-input"
                           type="text"
                           placeholder="Search"
                           aria-label="Search">
                </form>

                <a class="custom-logout-btn"
                   href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Sign out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <main role="main" class="col-md-10 col-lg-12 pt-3 px-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card text-white shadow-sm" style="background: linear-gradient(45deg, #ff7e5f, #feb47b);">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="mb-0">{{$totalUsers}}</h3>
                                    <small>Total Users</small>
                                </div>
                                <i class="fa-solid fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white shadow-sm" style="background: linear-gradient(45deg, #56ab2f, #a8e063);">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="mb-0">{{$totalOrders}}</h3>
                                    <small>Completed Orders</small>
                                </div>
                                <i class="fa-solid fa-circle-check fa-2x"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white shadow-sm" style="background: linear-gradient(45deg, #8360c3, #2ebf91);">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="mb-0">{{$totalProducts}}</h3>
                                    <small>Total Products</small>
                                </div>
                                <i class="fa-solid fa-box-open fa-2x"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white shadow-sm" style="background: linear-gradient(45deg, #36d1dc, #5b86e5);">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="mb-0">{{$totalEarnings}} zł</h3>
                                    <small>Total Earnings</small>
                                </div>
                                <i class="fa-solid fa-sack-dollar fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- sekcja z borderem -->
                <div class="dashboard-border">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <button class="btn btn-sm btn-outline-secondary">Share</button>
                                <button class="btn btn-sm btn-outline-secondary">Export</button>
                            </div>
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <span data-feather="calendar"></span>
                                {{request('range') === 'month' ? 'This month' : 'This week'}}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['range' => 'week']) }}">This week</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['range' => 'month']) }}">This month</a></li>
                            </ul>
                        </div>
                    </div>

                    <canvas id="earningsChart"></canvas>
                </div>
                <script>
                    const ctx = document.getElementById('earningsChart');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: @json($labels),
                            datasets: [{
                                label: 'Zarobki (PLN)',
                                data: @json($totals),
                                borderWidth: 1,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            }]
                        }
                    });
                </script>
            </main>
        </div>
    </div>



@endsection
@vite(['resources/css/admin.css'])
@vite(['resources/css/dashboard.css'])
