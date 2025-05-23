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
                                <label>Ulica *</label>
                                <input type="text" class="form-control" placeholder="Ulica">
                            </div>

                            <div class="form-group w-50">
                                <label>Numer domu/Mieszkania *</label>
                                <input type="text" class="form-control" placeholder="Numer domu/mieszkania">
                            </div>
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
                                <label>Ulica *</label>
                                <input type="text" class="form-control" placeholder="Ulica">
                            </div>

                            <div class="form-group w-50">
                                <label>Numer domu/Mieszkania *</label>
                                <input type="text" class="form-control" placeholder="Numer domu/mieszkania">
                            </div>
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

                <div class="cart-item d-flex align-items-center mb-3">
                    <img src="" alt="Product Image" style="width: 60px; height: 60px;">
                    <div class="ms-3">
                        <p class="mb-1">Smart Fitness Watch with Heart Rate Monitor & Activity Tracking</p>
                        <strong>$25.00 × 1</strong>
                    </div>
                </div>

                <hr>

                <h4>Metoda dostawy</h4>

                <div id="checkout-section" class="d-flex justify-content-between">
                    <div class="option-group">
                        <label class="option">
                            <input type="radio" name="shipping_method" value="dpd" checked>
                            <span class="option-title">DPD Kurier</span>
                            <span class="option-description"> Dostawa w 1-2 dni robocze</span>
                        </label>
                        <label class="option">
                            <input type="radio" name="shipping_method" value="inpost">
                            <span class="option-title">InPost Paczkomat</span>
                            <span class="option-description">Odbiór w paczkomacie</span>
                        </label>
                        <label class="option">
                            <input type="radio" name="shipping_method" value="dhl">
                            <span class="option-title">DHL Kurier</span>
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
                    <span>25.00 zł</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Opłata za dostawę</span>
                    <span>0.00 zł</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Podatek</span>
                    <span>0.00 zł</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between fw-bold">
                    <span>Suma całkowita</span>
                    <span>25.00 zł</span>
                </div>
            </div>
        </div>
    </div>

    <div class="button-wrapper">
        <a class="checkout-button" href="{{ route('checkout.summary') }}">
            Przejdź do podsumowania
        </a>
    </div>

@endsection
<script type="text/javascript" data-url="{{ url('/cart') }}">
    @yield('javascript')
</script>
@vite('resources/js/delete.js')
@vite(['resources/js/checkout.js'])
