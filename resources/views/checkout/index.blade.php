@extends('layouts.app-checkout')

@section('content')
    <div class="checkout-page">
        <div class="container checkout-container">
            <!-- Lewy kontener -->
            <div class="checkout-left">
                <h2>Zamówienie</h2>
                <br>

                <!-- adres rozliczeniowy -->
                <div id="billing-adress">
                    <h4>Adres rozliczeniowy</h4>
                    <form>
                        <div class="form-row d-flex gap-3 mt-3">
                            <div class="form-group w-50">
                                <label>Imię *</label>
                                <input type="text" class="form-control" placeholder="Imię">
                            </div>
                            <div class="form-group w-50">
                                <label>Nazwisko *</label>
                                <input type="text" class="form-control" placeholder="Nazwisko">
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>E-mail *</label>
                            <input type="email" class="form-control" placeholder="email@example.com">
                        </div>

                        <div class="form-row d-flex gap-3 mt-3">
                            <div class="form-group w-50">
                                <label>Ulica (ulica i numer) *</label>
                                <input type="text" class="form-control" placeholder="Ulica">
                            </div>

                            <div class="form-group w-50">
                                <label>Numer Mieszkania (opcjonalnie)</label>
                                <input type="text" class="form-control" placeholder="Numer mieszkania">
                            </div>
                        </div>


                        <div class="form-row d-flex gap-3 mt-3">
                            <div class="form-group w-50">
                                <label>Miasto *</label>
                                <input type="text" class="form-control" placeholder="Miasto">
                            </div>

                            <div class="form-group w-50">
                                <label>Kod pocztowy *</label>
                                <input type="text" class="form-control" placeholder="Kod pocztowy">
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Numer telefonu *</label>
                            <input type="number" class="form-control" placeholder="Numer telefonu">
                        </div>
                    </form>
                </div>


                <!-- Przycisk odpowiadajacy za wyswietlanie adresu wysylkowego -->
                <div class="form-check mb-4">
                    <br>
                        <input class="form-check-input" type="checkbox" id="sameAddressCheckbox" checked>
                        <label class="form-check-label" for="sameAddressCheckbox">
                            Wysyłka na ten sam adres co rozliczeniowy
                        </label>
                    <br>
                </div>


                <!-- adres wysylkowy -->
                <div id="shipping-adress">
                    <h4>Adres wysyłkowy</h4>
                    <form>
                        <div class="form-row d-flex gap-3 mt-3">
                            <div class="form-group w-50">
                                <label>Imię *</label>
                                <input type="text" class="form-control" placeholder="Imię">
                            </div>
                            <div class="form-group w-50">
                                <label>Nazwisko *</label>
                                <input type="text" class="form-control" placeholder="Nazwisko">
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>E-mail *</label>
                            <input type="email" class="form-control" placeholder="email@example.com">
                        </div>

                        <div class="form-row d-flex gap-3 mt-3">
                            <div class="form-group w-50">
                                <label>Ulica (pełna nazwa) *</label>
                                <input type="text" class="form-control" placeholder="Ulica">
                            </div>

                            <div class="form-group w-50">
                                <label>Numer Mieszkania (opcjonalnie)</label>
                                <input type="text" class="form-control" placeholder="Numer mieszkania">
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Miasto *</label>
                            <input type="text" class="form-control" placeholder="Miasto">
                        </div>

                        <div class="form-group mt-3">
                            <label>Kod pocztowy *</label>
                            <input type="text" class="form-control" placeholder="Kod pocztowy">
                        </div>

                        <div class="form-group mt-3">
                            <label>Numer telefonu *</label>
                            <input type="text" class="form-control" placeholder="Numer telefonu">
                        </div>
                    </form>
                </div>
            </div>



            <!-- Prawy kontener: Podsumowanie koszyka -->
            <div class="checkout-right">
                <h2>Podsumowanie koszyka</h2>

                <div class="cart-item p-3">

                    @foreach($cartItems as $item)
                        <div class="product-item d-flex align-items-center mb-3">
                            <img src="{{ $isGuest ? $item['image'] : $item->image }}"
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
                                    </div>
                                    <div class="fw-bold">
                                        x{{$quantity =  $isGuest ? $item['quantity'] : $item->quantity }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <hr>

                <h4>Metoda dostawy</h4>

                <div id="checkout-section" class="d-flex justify-content-between">
                    <div class="option-group">
                        <label class="option">
                            <input type="radio" name="shipping_method" value="dpd" data-price="20.00" checked>
                            <span class="option-title">DPD Kurier (20 zł)</span>
                            <span class="option-description"> Dostawa w 1-2 dni robocze</span>
                        </label>
                        <label class="option">
                            <input type="radio" name="shipping_method" data-price="10.00" value="inpost">
                            <span class="option-title">InPost Paczkomat (10 zł)</span>
                            <span class="option-description">Odbiór w paczkomacie</span>
                        </label>
                        <label class="option">
                            <input type="radio" name="shipping_method" data-price="15.00" value="dhl">
                            <span class="option-title">DHL Kurier (15 zł)</span>
                            <span class="option-description">Dostawa w 1-3 dni robocze</span>
                        </label>
                    </div>
                </div>

                <hr>

                <h4>Metoda płatności</h4>

                <div id="checkout-section" class="d-flex justify-content-between">

                    <div class="option-group">
                        <label class="option">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <span class="option-title">Płatność przy odbiorze</span>
                            <span class="option-description">Zapłać kurierowi przy dostawie</span>
                        </label>
                        <label class="option">
                            <input type="radio" name="payment_method" value="blik">
                            <span class="option-title">BLIK</span>
                            <span class="option-description">Szybka płatność mobilna</span>
                        </label>
                        <label class="option">
                            <input type="radio" name="payment_method" value="blik">
                            <span class="option-title">Karta płatnizca</span>
                            <span class="option-description">Podanie karty płatniczej</span>
                        </label>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <span>Podsumowanie</span>
                    <span id="productsTotal">{{number_format($totalProductPrice,2)}}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Opłata za dostawę</span>
                    <span id="shippingCost">0.00 zł</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between fw-bold">
                    <span>Łącznie do zapłaty</span>
                    <span id="totalPrice">{{number_format($totalProductPrice,2)}}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="button-wrapper">
        <a class="checkout-button" href="#">
            Zapłać
        </a>
    </div>

@endsection
<script type="text/javascript" data-url="{{ url('/cart') }}">
    @yield('javascript')
</script>
@vite('resources/js/delete.js')
@vite(['resources/js/checkout.js'])
