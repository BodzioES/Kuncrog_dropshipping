@extends('layouts.admin')

@section('content')


    <nav class="custom-navbar">
        <div class="custom-container">
            <!-- lewa strona -->
            <h1 class="custom-title">Dashboard</h1>

            <!-- prawa strona -->
            <div class="custom-actions d-flex align-items-center gap-2">
                <a class="custom-button-welcome" href="{{route('welcome')}}">
                    <button class="btn btn-secondary custom-button">Home page</button>
                </a>

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
                        <div class="card text-white shadow-sm" style="background: linear-gradient(45deg, #ff7e5f, #feb47b); border-radius: 20px;">
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
                        <div class="card text-white shadow-sm" style="background: linear-gradient(45deg, #56ab2f, #a8e063);border-radius: 20px;">
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
                        <div class="card text-white shadow-sm" style="background: linear-gradient(45deg, #8360c3, #2ebf91);border-radius: 20px;">
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
                        <div class="card text-white shadow-sm" style="background: linear-gradient(45deg, #36d1dc, #5b86e5);border-radius: 20px;">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="mb-0">{{$totalSumCurrentDay}} zł</h3>
                                    <small>Revenue Today</small>
                                </div>
                                <i class="fa-solid fa-sack-dollar fa-2x"></i>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row g-3 mb-4 d-flex align-items-stretch">

                    <div class="col-md-3">
                        <div class="totalEarnings h-100 d-flex justify-content-center align-items-center">
                            <div class="credit-card">
                                <div class="card-content text-center">
                                    <h2 class="card-amount">{{$totalEarnings}} zł</h2>
                                    <p class="card-label">Wallet Balance</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="bestProduct h-100 d-flex flex-column align-items-center justify-content-center text-center">
                            <h5 class="mb-2 text-secondary">Best Product</h5>
                            <h3 class="mb-1" style="font-weight: bold; color: #333;">{{$bestProduct->name}}</h3>
                            <p class="mb-2" style="font-weight: 500; color: #666;">Sold: {{$bestProduct->sumProduct}} pcs</p>
                            <img src="{{ asset('storage/products/' . $bestProduct->image_url) }}"
                                 alt="Photo"
                                 style="height: 150px; width: auto; object-fit: cover; border-radius: 15px; box-shadow: 2px 2px 6px rgba(0,0,0,0.1);">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="earningsChart h-100">
                            <canvas id="earningsChart"></canvas>
                        </div>
                    </div>

                </div>


                <!-- sekcja z borderem -->
                <div class="dashboard-border">
                    <h2>Sales revenue</h2>
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <button class="btn btn-sm btn-outline-secondary">Share</button>
                                <button class="btn btn-sm btn-outline-secondary">Export</button>
                            </div>
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <span data-feather="calendar"></span>
                                {{request('range2') === 'month2' ? 'This month' : 'This week'}}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['range' => 'week', 'range2' => 'week2']) }}">This week</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['range' => 'month', 'range2' => 'month2']) }}">This month</a></li>
                            </ul>
                        </div>
                    </div>
                    <canvas id="differentEarnings"></canvas>
                </div>
                <script>
                    const ctxV2 = document.getElementById('differentEarnings')
                    new Chart(ctxV2, {
                       type: 'bar',
                       data: {
                           labels: @json($labels),
                           datasets: [
                               {
                                    label: 'Earnings (Current)',
                                    data: @json($totals),
                                    borderWidth: 1,
                                    backgroundColor: 'rgba(154,19,204,0.6)',
                                },
                               {
                                   label: 'Earnings (Previous)',
                                   data: @json($previousTotals),
                                   borderWidth: 1,
                                   backgroundColor: 'rgba(19,84,204,0.6)',
                                },
                               {
                                   label: 'Diffrence (%)',
                                   data: @json($percentageDifferent),
                                   type: 'line', //linia na wykresie
                                   borderColor: 'rgba(255,99,132,1)',
                                   backgroundColor: 'rgba(255,99,132,1)',
                                   yAxisID: 'y1', // osobna os dla procentow
                                   tension: 0.3, //gladka linia
                               }
                           ]
                       },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                }
                            },
                            scales: {
                                x: {
                                    stacked: false, //osobne slupki obok siebie
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Earnings (PLN)'
                                    }
                                },
                                y1: {
                                    position: 'right',
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Change (%)'
                                    },
                                    grid: {
                                        drawOnChartArea: false //zeby kratki sie nie nakladaly
                                    }
                                }
                            }
                        }
                    });

                    const ctx = document.getElementById('earningsChart');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: @json($labels),
                            datasets: [{
                                label: 'Earnings (PLN)',
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
