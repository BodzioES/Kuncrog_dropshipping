@extends('layouts.admin')

@section('content')

    <div class="container my-5">
        <div class="cart-body">
            {{-- FORMULARZ DO EDYCJI DANYCH Z ZAMOWIENIA --}}
            {{-- WYSYLA DANE Z FORMULARZA DO CONTROLLERA KTORY MA FUNKCJE UPDATE, JEST PRZEKAZYWANY ID ZAMOWIENIA (TO WYSTARCZA) --}}
            <form method="POST" action="{{ route('admin.orders.update', $order->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h2 class="mb-4">Order preview</h2>
                <!-- Sekcja podstawowych informacji -->
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Order Information</strong>
                    </div>
        <!------------------------------------------------------------------------------------------------------------------------------->
                    <div class="card-body row">
                        <div class="col-md-3">
                            <strong>Order number:</strong>
                            <input type="number" min="1" class="form-control @error('order.id') is-invalid @enderror" name="order[id]" value="{{$order->id}}" required autocomplete="id">
                        </div>
        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-3">
                            <strong>Status:</strong>
                            <select id="status" class="form-control @error('order.status') is-invalid @enderror" name="order[status]">
                                {{-- STWORZONA ZMIENNA TABLICOWA ZE STATUSAMI Z KONTROLERA  --}}
                                @foreach($statuses as $status) {{-- Z TABLICY ROBIMY OSOBNY OBIEKT --}}
                                    <option value="{{$status}}" {{ $order->status === $status ? 'selected' : '' }}>
                                        {{ucfirst($status)}} {{-- POROWNUJEMY STATUS Z ZAMOWIENIA DO STATUSU Z TABLICY, JESLI JEST INNY TO GO ZAMIENIA JESLI NIE TO NIC NIE ROBI --}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-3">
                            <strong>Total amount:</strong>
                            <input type="number" min="1" class="form-control @error('order.total_price') is-invalid @enderror" name="order[total_price]" value="{{$order->total_price}}" required autocomplete="total_price">
                        </div>
        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-3">
                            <strong>Date of submission:</strong>                                                                                             {{-- ZMIENIA TO FORMAT DATY --}}
                            <input type="date"  class="form-control @error('order.created_at') is-invalid @enderror" name="order[created_at]" value="{{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}" required autocomplete="created_at">
                        </div>
        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-3">
                            <strong>Payment method:</strong>
                            <select id="id_payment_method" class="form-control @error('order.id_payment_method') is-invalid @enderror" name="order[id_payment_method]">
                                {{-- ZMIENNA KTORA PRZYPISANA MA TABELE PAYMENTMETHOD Z RELACJI "paymentMethod Z TABELI ORDERS --}}
                                @foreach($paymentMethods as $paymentMethod){{-- SPRADZANE JEST CZY ZMIENNA ZOSTALA WYBRANA JESLI NIE TO ZASTEPUJA TA STARA --}}
                                    <option value="{{$paymentMethod->id}}" {{ $order->id_payment_method === $paymentMethod->id ? 'selected' : '' }}>
                                        {{-- FUNKCJA KTORA ZAMIENIA PIERWSZY ZNAK NA DUZA LITERKE --}} {{ucfirst($paymentMethod->name)}}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-3">
                            <strong>Delivery methof:</strong>
                            <select id="id_shipping_method" class="form-control @error('order.id_shipping_method') is-invalid @enderror" name="order[id_shipping_method]">
                                {{-- ZMIENNA KTORA PRZYPISANA MA TABELE SHIPPINGMETHOD Z RELACJI "shippingtMethod Z TABELI ORDERS --}}
                            @foreach($shippingMethods as $shippingMethod){{-- ANALOGICZNIE JAK POWYZEJ --}}
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
                        <strong>Address details</strong>
                    </div>
                    <div class="card-body row">

                        {{-- name="" jest uzywany w kontrolerze do validated, value wyswietla biezaca wartosc w okienku edytacyjnym --}}

                        <div class="col-md-4">
                            <strong>Name:</strong>
                            <input type="text" id="first_name" class="form-control @error('address.first_name') is-invalid @enderror" name="address[first_name]" value="{{$order->address->first_name}}">
                        </div>
                        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-4">
                            <strong>Surname:</strong>
                            <input type="text" id="last_name" class="form-control @error('address.last_name') is-invalid @enderror" name="address[last_name]" value="{{$order->address->last_name}}">
                        </div>
                        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-4">
                            <strong>Email:</strong>
                            <input type="text" id="email" class="form-control @error('address.email') is-invalid @enderror" name="address[email]" value="{{$order->address->email}}">
                        </div>
                        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-4">
                            <strong>Phone:</strong>
                            <input type="text" id="phone_number" class="form-control @error('address.phone_number') is-invalid @enderror" name="address[phone_number]" value="{{$order->address->phone_number}}">
                        </div>
                        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-4">
                            <strong>Street and number:</strong>
                            <input type="text" id="street_and_house_number" class="form-control @error('address.street_and_house_number') is-invalid @enderror" name="address[street_and_house_number]" value="{{$order->address->street_and_house_number}}">
                        </div>
                        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-4">
                            <strong>Apartment number (optional):</strong>
                            <input type="text" id="apartment_number" class="form-control @error('address.apartment_number') is-invalid @enderror" name="address[apartment_number]" value="{{$order->address->apartment_number}}">
                        </div>
                        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-4">
                            <strong>Postal code:</strong>
                            <input type="text" id="postal_code" class="form-control @error('address.postal_code') is-invalid @enderror" name="address[postal_code]" value="{{$order->address->postal_code}}">
                        </div>
                        <!------------------------------------------------------------------------------------------------------------------------------->
                        <div class="col-md-4">
                            <strong>City:</strong>
                            <input type="text" id="city" class="form-control @error('address.city') is-invalid @enderror" name="address[city]" value="{{$order->address->city}}">
                        </div>
                        <!------------------------------------------------------------------------------------------------------------------------------->
                    </div>
                </div>

                <!-- Sekcja produktów -->
                <div class="card">
                    <div class="card-header">
                        <strong>Products</strong>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered m-0 d-none d-md-table">
                            <thead class="table-light">
                            <tr>
                                <th>Product name</th>
                                <th>quantity</th>
                                <th>Unit price</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- relacja orders->order_items gdzie pobieramy kazdy produkt z zamowienia i zapisujemy go osobno jako $products --}}
                            @foreach($order->items as $products)
                                @php
                                    $quantity = $products->quantity;
                                    $price = $products->current_price;
                                    $totalPrice = $quantity * $price;
                                @endphp
                                <tr>
                                    {{-- uzywamy $products->product->name bo nazwa nie znajduje sie bezposrednio w tabeli order_items wiec musimy
                                      relacja dostac sie do tabeli products i z tamtad wziasc nazwe produktu--}}
                                    <td>{{$products->product->name}}</td>
                                    <td>x{{$products->quantity}}</td>
                                    <td>{{$products->current_price}} zł</td>
                                    <td>{{number_format($totalPrice,2,',','')}} zł</td>
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
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <a href="{{route('admin.orders.index')}}">
                            <button class="btn btn-secondary">Back</button>
                        </a>
                        <a href="{{route('admin.orders.invoice',$order)}}">
                            <button class="btn btn-warning">Download</button>
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
    @vite('resources/css/orderEdit.css')
@endsection
