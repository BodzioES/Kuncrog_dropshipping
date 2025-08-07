@extends('layouts.admin')

@section('content')

    <div class="container my-5">
        <div class="cart-body">
            <form method="POST" action="{{ route('admin.orders.update', $order->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h2 class="mb-4">Podgląd zamówienia</h2>
                <!-- Sekcja podstawowych informacji -->
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Informacje o zamówieniu</strong>
                    </div>
        <!------------------------------------------------------------------------------------------------------------------------------->
                    <div class="card-body row">
                        <div class="col-md-3">
                            <strong>Numer zamówienia:</strong>
                            <input type="number" min="1" class="form-control @error('order.id') is-invalid @enderror" name="order[id]" value="{{$order->id}}" required autocomplete="id">
                        </div>
        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-3">
                            <strong>Status:</strong>
                            <select id="status" class="form-control @error('order.status') is-invalid @enderror" name="order[status]">
                                @foreach($statuses as $status)
                                    <option value="{{$status}}" {{ $order->status === $status ? 'selected' : '' }}>
                                        {{ucfirst($status)}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-3">
                            <strong>Łączna kwota:</strong>
                            <input type="number" min="1" class="form-control @error('order.total_price') is-invalid @enderror" name="order[total_price]" value="{{$order->total_price}}" required autocomplete="total_price">
                        </div>
        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-3">
                            <strong>Data złożenia:</strong>
                            <input type="date"  class="form-control @error('order.created_at') is-invalid @enderror" name="order[created_at]" value="{{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}" required autocomplete="created_at">
                        </div>
        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-3">
                            <strong>Metoda płatności:</strong>
                            <select id="id_payment_method" class="form-control @error('order.id_payment_method') is-invalid @enderror" name="order[id_payment_method]">
                                @foreach($paymentMethods as $paymentMethod)
                                    <option value="{{$paymentMethod->id}}" {{ $order->id_payment_method === $paymentMethod->id ? 'selected' : '' }}>
                                        {{ucfirst($paymentMethod->name)}}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-3">
                            <strong>Metoda dostawy:</strong>
                            <select id="id_shipping_method" class="form-control @error('order.id_shipping_method') is-invalid @enderror" name="order[id_shipping_method]">
                            @foreach($shippingMethods as $shippingMethod)
                                <option value="{{$shippingMethod->id}}" {{ $order->id_shipping_method === $shippingMethod->id ? 'selected' : '' }}>
                                    {{ucfirst($shippingMethod->name)}}
                                </option>
                            @endforeach
                            </select>
                            @error('id_shipping_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Sekcja adresowa -->
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Dane adresowe</strong>
                    </div>
                    <div class="card-body row">

                        <div class="col-md-4">
                            <strong>Imię:</strong>
                            <input type="text" id="first_name" class="form-control @error('address.first_name') is-invalid @enderror" name="address[first_name]" value="{{$order->address->first_name}}">
                        </div>
                        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-4">
                            <strong>Nazwisko:</strong>
                            <input type="text" id="last_name" class="form-control @error('address.last_name') is-invalid @enderror" name="address[last_name]" value="{{$order->address->last_name}}">
                        </div>
                        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-4">
                            <strong>Email:</strong>
                            <input type="text" id="email" class="form-control @error('address.email') is-invalid @enderror" name="address[email]" value="{{$order->address->email}}">
                        </div>
                        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-4">
                            <strong>Telefon:</strong>
                            <input type="text" id="phone_number" class="form-control @error('address.phone_number') is-invalid @enderror" name="address[phone_number]" value="{{$order->address->phone_number}}">
                        </div>
                        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-4">
                            <strong>Ulica i nr domu:</strong>
                            <input type="text" id="street_and_house_number" class="form-control @error('address.street_and_house_number') is-invalid @enderror" name="address[street_and_house_number]" value="{{$order->address->street_and_house_number}}">
                        </div>
                        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-4">
                            <strong>Numer mieszkania (opcjonalnie):</strong>
                            <input type="text" id="apartment_number" class="form-control @error('address.apartment_number') is-invalid @enderror" name="address[apartment_number]" value="{{$order->address->apartment_number}}">
                        </div>
                        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-4">
                            <strong>Kod pocztowy:</strong>
                            <input type="text" id="postal_code" class="form-control @error('address.postal_code') is-invalid @enderror" name="address[postal_code]" value="{{$order->address->postal_code}}">
                        </div>
                        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-4">
                            <strong>Miasto:</strong>
                            <input type="text" id="city" class="form-control @error('address.city') is-invalid @enderror" name="address[city]" value="{{$order->address->city}}">
                        </div>
                        <!------------------------------------------------------------------------------------------------------------------------------->
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
                                    <td>{{number_format($totalPrice,2,',','')}} zł</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <a href="{{route('admin.orders.index')}}">
                            <button class="btn btn-secondary">Powrót</button>
                        </a>
                        <a href="{{route('admin.orders.invoice',$order)}}">
                            <button class="btn btn-warning">Pobierz</button>
                        </a>
                        <button type="submit" class="btn btn-primary">
                            {{__('shop.button.save')}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    @vite('resources/js/delete.js')
    @vite('resources/css/order.css')
@endsection
