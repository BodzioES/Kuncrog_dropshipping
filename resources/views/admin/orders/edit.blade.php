@extends('layouts.admin')

@section('content')

    <div class="container my-5">
        <h2 class="mb-4">Podgląd zamówienia</h2>
        <!-- Sekcja podstawowych informacji -->
        <div class="card mb-4">
            <div class="card-header">
                <strong>Informacje o zamówieniu</strong>
            </div>
            <div class="card-body row">
                <div class="col-md-3">
                    <strong>Numer zamówienia:</strong>
                    <input type="number" min="1" class="form-control @error('id') is-invalid @enderror" name="id" value="{{$order->id}}" required autocomplete="id">
                </div>
                <div class="col-md-3">
                    <strong>Status:</strong> {{$order->status}}
                </div>
                <div class="col-md-3">
                    <strong>Łączna kwota:</strong> {{$order->total_price}} zł
                </div>
                <div class="col-md-3">
                    <strong>Data złożenia:</strong> {{$order->created_at}}
                </div>
                <div class="col-md-3">
                    <strong>Metoda płatności:</strong> {{$order->paymentMethod->name}}
                </div>
                <div class="col-md-3">
                    <strong>Metoda dostawy:</strong> {{$order->shippingMethod->name}}
                </div>
            </div>
        </div>

        <!-- Sekcja adresowa -->
        <div class="card mb-4">
            <div class="card-header">
                <strong>Dane adresowe</strong>
            </div>
            <div class="card-body row">
                <div class="col-md-4"><strong>Imię i nazwisko:</strong> {{$order->address->first_name}} {{$order->address->last_name}}</div>
                <div class="col-md-4"><strong>Email:</strong> {{$order->address->email}}</div>
                <div class="col-md-4"><strong>Telefon:</strong> {{$order->address->phone_number}}</div>
                <div class="col-md-4"><strong>Ulica i nr domu:</strong> {{$order->address->street_and_house_number}}</div>
                <div class="col-md-4"><strong>Numer mieszkania (opcjonalnie):</strong> {{$order->address->apartment_number == null ? 'brak' : ''}}</div>
                <div class="col-md-4"><strong>Kod pocztowy:</strong> {{$order->address->postal_code}}</div>
                <div class="col-md-4"><strong>Miasto:</strong> {{$order->address->city}}</div>
            </div>
        </div>

        <!-- Sekcja produktów -->
        <div class="card">
            <div class="card-header">
                <strong>Produkty</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered m-0">
                    <thead class="table-light">
                    <tr>
                        <th>Nazwa produktu</th>
                        <th>Ilość</th>
                        <th>Cena jednostkowa</th>
                        <th>Łącznie</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->items as $products)
                        @php
                            $quantity = $products->quantity;
                            $price = $products->current_price;
                            $totalPrice = $quantity * $price;
                        @endphp
                        <tr>
                            <td>{{$products->product->name}}</td>
                            <td>x{{$products->quantity}}</td>
                            <td>{{$products->current_price}} zł</td>
                            <td>{{$totalPrice}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <a href="{{route('admin.orders.edit',$order->id)}}">
            <button class="btn btn-primary">Edytuj</button>
        </a>
        <a href="{{route('admin.orders.index')}}">
            <button class="btn btn-secondary">Powrót</button>
        </a>
        <a href="{{route('admin.orders.invoice',$order)}}">
            <button class="btn btn-warning">Pobierz</button>
        </a>
    </div>

@endsection

@section('scripts')
    @vite('resources/js/delete.js')
    @vite('resources/css/order.css')
@endsection
