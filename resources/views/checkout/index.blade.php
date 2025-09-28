@extends('layouts.app-checkout')

@section('content')
    <div class="checkout-page">
        <form id="checkout-form" method="POST" action="{{route('checkout.store')}}">
            @csrf
            <div class="container checkout-container">
                <!-- Lewy kontener -->
                <div class="checkout-left">
                    <h2>Order</h2>
                    <br>

                    <!-- adres rozliczeniowy -->
                    <div id="billing-adress">
                        <h4>Billing address</h4>
                        <div class="form-row d-flex gap-3 mt-3">
                            <div class="form-group w-50">
                                <label>Name *</label>
                                <input type="text" name="address[first_name]" class="form-control" placeholder="Imię">
                            </div>
                            <div class="form-group w-50">
                                <label>Surname *</label>
                                <input type="text" name="address[last_name]" class="form-control" placeholder="Nazwisko">
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>E-mail *</label>
                            <input type="email" name="address[email]" class="form-control" placeholder="email@example.com">
                        </div>

                        <div class="form-row d-flex gap-3 mt-3">
                            <div class="form-group w-50">
                                <label>Street (street and number) *</label>
                                <input type="text" name="address[street_and_house_number]" class="form-control" placeholder="Ulica">
                            </div>

                            <div class="form-group w-50">
                                <label>Apartment number (optional)</label>
                                <input type="text" name="address[apartment_number]" class="form-control" placeholder="Numer mieszkania">
                            </div>
                        </div>


                        <div class="form-row d-flex gap-3 mt-3">
                            <div class="form-group w-50">
                                <label>City *</label>
                                <input type="text" name="address[city]" class="form-control" placeholder="Miasto">
                            </div>

                            <div class="form-group w-50">
                                <label>Postal code *</label>
                                <input type="text" name="address[postal_code]" class="form-control" placeholder="Kod pocztowy">
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Phone number *</label>
                            <input type="text" name="address[phone_number]" class="form-control" placeholder="Numer telefonu">
                        </div>
                    </div>


                    <!-- Przycisk odpowiadajacy za wyswietlanie adresu wysylkowego -->
                    <div class="form-check mb-4">
                        <br>
                            <input class="form-check-input" type="checkbox" id="sameAddressCheckbox" checked>
                            <label class="form-check-label" for="sameAddressCheckbox">
                                Shipping to the same address as billing
                            </label>
                        <br>
                    </div>


                    <!-- adres wysylkowy -->
                    <div id="shipping-adress">
                        <h4>Shipping address</h4>
                        <div class="form-row d-flex gap-3 mt-3">
                            <div class="form-group w-50">
                                <label>Name *</label>
                                <input type="text" name="address[first_name]" class="form-control" placeholder="Imię">
                            </div>
                            <div class="form-group w-50">
                                <label>Surname *</label>
                                <input type="text" name="address[last_name]" class="form-control" placeholder="Nazwisko">
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>E-mail *</label>
                            <input type="email" name="address[email]" class="form-control" placeholder="email@example.com">
                        </div>

                        <div class="form-row d-flex gap-3 mt-3">
                            <div class="form-group w-50">
                                <label>Street (street and number) *</label>
                                <input type="text" name="address[street_and_house_number]" class="form-control" placeholder="Ulica">
                            </div>

                            <div class="form-group w-50">
                                <label>Apartment number (optional)</label>
                                <input type="text" name="address[apartment_number]" class="form-control" placeholder="Numer mieszkania">
                            </div>
                        </div>


                        <div class="form-row d-flex gap-3 mt-3">
                            <div class="form-group w-50">
                                <label>City *</label>
                                <input type="text" name="address[city]" class="form-control" placeholder="Miasto">
                            </div>

                            <div class="form-group w-50">
                                <label>Postal code *</label>
                                <input type="text" name="address[postal_code]" class="form-control" placeholder="Kod pocztowy">
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Phone number *</label>
                            <input type="text" name="address[phone_number]" class="form-control" placeholder="Numer telefonu">
                        </div>
                    </div>
                </div>



                <!-- Prawy kontener: Podsumowanie koszyka -->
                <div class="checkout-right">
                    <h2>Basket summary</h2>

                    <div class="cart-item p-3">

                        @foreach($cartItems as $item)
                            <div class="product-item d-flex align-items-center mb-3">
                                <img src="{{asset('storage/products/' . ($isGuest ? $item['image'] : $item->image))}}"
                                     class="product-img me-3"
                                     alt="photo"
                                     style="width: 80px; height: auto; object-fit: contain;">

                                <div class="flex-grow-1">
                                    <div class="fw-bold fs-5">
                                        {{$isGuest ? $item['name'] : $item->name }}
                                    </div>

                                    <div class="d-flex justify-content-between mt-1">
                                        <div class="fw-bold text-muted">
                                            {{$price =  $isGuest ? $item['price'] : $item->price }} zł
                                            <input type="hidden" name="items[{{$loop->index}}][current_price]" value="{{$price}}">
                                        </div>
                                        <div class="fw-bold">
                                            x{{$quantity =  $isGuest ? $item['quantity'] : $item->quantity }}
                                            <input type="hidden" name="items[{{$loop->index}}][quantity]" value="{{$quantity}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="items[{{$loop->index}}][id_product]" value="{{ $isGuest ? $item['id_product'] : $item->id_product }}">
                        @endforeach
                    </div>

                    <hr>

                    <h4>Delivery method</h4>

                    <div id="checkout-section" class="d-flex justify-content-between">
                        <div class="option-group">
                            @foreach($shippingMethods as $method)
                                <label class="option">
                                    <input type="radio" name="id_shipping_method" value="{{ $method->id }}">
                                    <span class="option-title">{{ $method->name }} ({{ number_format($method->price, 2) }} zł)</span>
                                    <span class="option-description">{{ $method->description }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <hr>

                    <h4>Payment method</h4>

                    <div id="checkout-section" class="d-flex justify-content-between">

                        <div class="option-group">
                            @foreach($paymentMethods as $method)
                                <label class="option">
                                    <input type="radio" name="id_payment_method" value="{{ $method->id }}">
                                    <span class="option-title">{{ $method->name }}</span>
                                    <span class="option-description">{{ $method->description }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span>Summary</span>
                        <span id="productsTotal">{{number_format($totalProductPrice,2)}} zł</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Delivery fee</span>
                        <span id="shippingCost">0.00 zł</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total to be paid</span>
                        <span id="totalPrice" name="total_price">{{number_format($totalProductPrice,2)}} zł</span>
                        <input type="hidden" name="total_price" value="{{$totalProductPrice}}">
                    </div>
                </div>
            </div>
                <div class="button-wrapper">
                    <button type="submit" class="checkout-button">Pay</button>
                </div>
        </form>
    </div>


@endsection
<script type="text/javascript" data-url="{{ url('/cart') }}">
    @yield('javascript')
</script>
@vite('resources/js/delete.js')
@vite(['resources/js/checkout.js'])
@vite('resources/css/checkout.css')
