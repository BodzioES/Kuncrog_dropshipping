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
                        <option value="pending" {{request('status') === 'pending' ? 'selected' : ''}}>W realizacji</option>
                        <option value="shipped" {{request('status') === 'shipped' ? 'selected' : ''}}>Zrealizowane</option>
                        <option value="delivered" {{request('status') === 'delivered' ? 'selected' : ''}}>Dostarczone</option>
                        <option value="cancelled" {{request('status') === 'cancelled' ? 'selected' : ''}}>Anulowane</option>
                    </select>
                </div>

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
                        <td colspan="1" class="text-center text-muted py-4">
                            {{$order->created_at}}
                        </td>
                        <td colspan="1" class="text-center text-muted py-4">
                            {{$order->id}}
                        </td>
                        <td colspan="1" class="text-center text-muted py-4">
                            {{$order->address->first_name}} {{$order->address->last_name}}
                        </td>
                        <td colspan="1" class="text-center text-muted py-4">
                            {{$order->paymentMethod->name}}
                        </td>
                        <td colspan="1" class="text-center text-muted py-4">
                            {{$order->total_price}}
                        </td>
                        <td colspan="1" class="text-center text-muted py-4">
                            {{$order->status}}
                        </td>
                        <td colspan="1" class="text-center text-muted py-4">

                            <a href="{{route('admin.orders.show',$order->id)}}">
                                <button><i class="fa-solid fa-magnifying-glass"></i></button>
                            </a>

                            <a href="{{route('admin.orders.edit',$order->id)}}">
                                <button><i class="fa-solid fa-pen-to-square"></i></button>
                            </a>

                            <button class="delete" data-id="{{$order->id}}" data-url="{{route('admin.orders.index')}}"><i class="fa-solid fa-trash"></i></button>

                            <a href="{{route('admin.orders.invoice',$order)}}">
                                <button><i class="fa-solid fa-file-pdf"></i></button>
                            </a>

                        </td>
                    </tr>
                @empty
                    <td colspan="7" class="text-center text-muted py-4">
                        Brak zamówień do wyświetlenia
                    </td>
                @endforelse
                </tbody>
                {{$orders->links()}}
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/delete.js')
    @vite('resources/css/order.css')
@endsection


