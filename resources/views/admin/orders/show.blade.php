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
                <div class="col-md-3"><strong>Order number:</strong> {{$order->id}}</div>
                <div class="col-md-3"><strong>Status:</strong> {{$order->status}}</div>
                <div class="col-md-3"><strong>Total amount:</strong> {{$order->total_price}} zł</div>
                <div class="col-md-3"><strong>date of submission:</strong> {{$order->created_at}}</div>
                <div class="col-md-3"><strong>Sipping method:</strong> {{$order->paymentMethod->name}}</div>
                <div class="col-md-3"><strong>Delivery method:</strong> {{$order->shippingMethod->name}}</div>
            </div>
        </div>

        <!-- Sekcja adresowa -->
        <div class="card mb-4">
            <div class="card-header">
                <strong>Address details</strong>
            </div>
            <div class="card-body row">
                <div class="col-md-4"><strong>Name and Surname:</strong> {{$order->address->first_name}} {{$order->address->last_name}}</div>
                <div class="col-md-4"><strong>Email:</strong> {{$order->address->email}}</div>
                <div class="col-md-4"><strong>Phone:</strong> {{$order->address->phone_number}}</div>
                <div class="col-md-4"><strong>Street and house number:</strong> {{$order->address->street_and_house_number}}</div>
                <div class="col-md-4"><strong>Apartment number (optional):</strong> {{$order->address->apartment_number == null ? 'brak' : ''}}</div>
                <div class="col-md-4"><strong>Postal code:</strong> {{$order->address->postal_code}}</div>
                <div class="col-md-4"><strong>City:</strong> {{$order->address->city}}</div>
            </div>
        </div>

        <!-- Sekcja produktów -->
        <div class="card">
            <div class="card-header">
                <strong>Products</strong>
            </div>
            <div class="card-body p-0">
                {{--  Desktop  --}}
                <table class="table table-bordered m-0 table-desktop d-none d-md-table">
                    <thead class="table-light">
                    <tr>
                        <th>Product name</th>
                        <th>Quantity</th>
                        <th>Unit price</th>
                        <th>Total</th>
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
                            <td>x{{$quantity}}</td>
                            <td>{{$price}} zł</td>
                            <td>{{$totalPrice}} zł</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{--  Mobile  --}}
                <div class="table-mobile d-block d-md-none p-3">
                    @foreach($order->items as $products)
                        @php
                            $quantity = $products->quantity;
                            $price = $products->current_price;
                            $totalPrice = $quantity * $price;
                        @endphp
                        <div class="product-card mb-3 p-3 border rounded shadow-sm bg-light">
                            <p class="product-name mb-2">{{$products->product->name}}</p>
                            <div class="product-info d-flex justify-content-between text-muted small">
                                <span><strong>Quantity:</strong> x{{$quantity}}</span>
                                <span><strong>Price:</strong> {{$price}} zł</span>
                                <span><strong>Total:</strong> {{number_format($totalPrice,2,',','')}} zł</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            </div>
            <a href="{{route('admin.orders.edit',$order->id)}}">
                <button class="btn btn-primary">Edit</button>
            </a>
            <a href="{{route('admin.orders.index')}}">
                <button class="btn btn-secondary">Back</button>
            </a>
            <a href="{{route('admin.orders.invoice',$order)}}">
                <button class="btn btn-warning">Download</button>
            </a>
        </div>
    </div>

@endsection

@section('scripts')
    @vite('resources/js/delete.js')
    @vite('resources/css/order.css')
    @vite('resources/css/orderShow.css')
@endsection
