@extends('layouts.admin')

@section('content')
    <div class="container table-container">
        <h3 class="mb-4">Order Tracking</h3>
        <div class="table-responsive shadow-sm rounded bg-white">

            <form method="GET" action="{{route('admin.orders.index')}}" class="row g-2 mb-3 align-items-end">

                <div class="col-auto">
                    <label for="status" class="form-label small mb-1">Status</label>
                    <select name="status" id="status" class="form-select form-select-sm">
                        <option value="">Wszystkie</option>
                        <!-- request() sluzy do pobierania obecnego zapytania HTTP, w tym przypadku POST
                         po prostu sprawdza czy dana opcja jest zaznaczona a 'status' jest przekazywany do kontrolera -->
                        <option value="pending" {{request('status') === 'pending' ? 'selected' : ''}}>W realizacji</option>
                        <option value="shipped" {{request('status') === 'shipped' ? 'selected' : ''}}>Zrealizowane</option>
                        <option value="delivered" {{request('status') === 'delivered' ? 'selected' : ''}}>Dostarczone</option>
                        <option value="cancelled" {{request('status') === 'cancelled' ? 'selected' : ''}}>Anulowane</option>
                    </select>
                </div>

                <!-- id, created_at itd, sa przekazywane do kontrolera za pomoca request do zmiennej w php przypisujemy te dane za pomoca
                 $request (czyli to co wysylamy formularzem) ->query (czyli nasza kwerenda) i w nawiasach nazwa tego requesta, czyli id, full_name itd-->
                <div class="col-auto">
                    <label for="id" class="form-label small mb-1">Numer zamówienia</label>
                    <input type="number" name="id" id="id" value="{{request('id')}}" class="form-control form-control-sm" placeholder="Numer zamówienia">
                </div>

                <div class="col-auto">
                    <label for="created_at" class="form-label small mb-1">Data zamówienia</label>
                    <input type="date" name="created_at" id="created_at" value="{{request('created_at')}}" class="form-control form-control-sm" placeholder="Data zamówienia">
                </div>

                <div class="col-auto">
                    <label for="full_name" class="form-label small mb-1">Osoba kupująca</label>
                    <input type="text" name="full_name" id="full_name" value="{{request('full_name')}}" class="form-control form-control-sm" placeholder="Imię i nazwisko">
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-primary">Filtruj</button>
                </div>

                <!-- jesli dana opcja filtracji jest zaznaczona to po przeladowaniu strony wyswietla nam sie przycisk ktory moze wyczyscic te filtry -->
                @if(request()->filled('status') || request()->filled('id') || request()->filled('created_at') || request()->filled('full_name'))
                    <div class="col-auto">
                        <a href="{{route('admin.orders.index')}}" class="btn btn-sm btn-outline-secondary">Wyczyść</a>
                    </div>
                @endif

            </form>

            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th scope="col">Data zamówienia</th>
                    <th scope="col">Numer zamówienia</th>
                    <th scope="col">Osoba kupująca</th>
                    <th scope="col">Metoda płatności</th>
                    <th scope="col">Łączna kwota do zapłaty</th>
                    <th scope="col">Status</th>
                    <th scope="col">Akcje</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td data-label="Data zamówienia">{{$order->created_at}}</td>
                        <td data-label="Numer zamówienia">#{{$order->id}}</td>
                        <td data-label="Osoba kupująca">{{$order->address->first_name}} {{$order->address->last_name}}</td>
                        <td data-label="Metoda płatności">{{$order->paymentMethod->name}}</td>
                        <td data-label="Łączna kwota">{{$order->total_price}} zł</td>
                        <td data-label="Status">{{$order->status}}</td>
                        <td data-label="Akcje">
                            <a href="{{route('admin.orders.show',$order)}}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </a>
                            <a href="{{route('admin.orders.edit',$order->id)}}" class="btn btn-sm btn-outline-warning me-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="{{route('admin.orders.invoice',$order)}}" class="btn btn-sm btn-outline-danger">
                                <i class="fa-solid fa-file-pdf"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Brak zamówień do wyświetlenia
                        </td>
                    </tr>
                @endforelse
                </tbody>
                <!-- generuje HTML z linkami do kolejnych stron wyników (np. „Poprzednia”, „1”, „2”, „Następna”)
                wstawiajac to automatycznie wyswietlamy kontrolki paginacji-->
                {{$orders->links()}}
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/delete.js')
    @vite('resources/css/order.css')
@endsection


