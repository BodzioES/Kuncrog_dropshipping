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
                    <img src="/images/watch.png" alt="Product Image" style="width: 60px; height: 60px;">
                    <div class="ms-3">
                        <p class="mb-1">Smart Fitness Watch with Heart Rate Monitor & Activity Tracking</p>
                        <strong>$25.00 × 1</strong>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <h4>Metoda dostawy</h4>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <h4>Metoda płatności</h4>
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
@endsection
<script type="text/javascript" data-url="{{ url('/cart') }}">
    @yield('javascript')
</script>
@vite('resources/js/delete.js')
@vite(['resources/js/checkout.js'])
