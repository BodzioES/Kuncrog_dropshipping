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
                    <div id="billing-address">
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
                    <div id="shipping-address">
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
                        <!-- Sekcja wyboru paczkomatu InPost -->
                        <div id="inpost-section" class="mt-3" style="display: none;">
                            <button type="button" id="openInpostModal" class="btn btn-outline-primary">
                                Wybierz paczkomat
                            </button>

                            <input type="hidden" name="inpost_locker" id="inpostLocker">
                            <p id="lockerInfo" class="mt-2 text-success fw-bold"></p>
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

        <!-- Modal z mapa InPost -->
        <div id="inpostModal" class="inpost-modal">
            <div class="inpost-modal-content">
                <span class="inpost-close">&times;</span>

                <inpost-geowidget
                    id="inpost-geowidget"
                    {{--  Token geowidget  --}}
                    token="eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJzQlpXVzFNZzVlQnpDYU1XU3JvTlBjRWFveFpXcW9Ua2FuZVB3X291LWxvIn0.eyJleHAiOjIwNzUzOTIyOTIsImlhdCI6MTc2MDAzMjI5MiwianRpIjoiNzNhYzFiNzQtYzlkZC00OWY5LTgxOTItODRiMTI1NjNhYmQ2IiwiaXNzIjoiaHR0cHM6Ly9sb2dpbi5pbnBvc3QucGwvYXV0aC9yZWFsbXMvZXh0ZXJuYWwiLCJzdWIiOiJmOjEyNDc1MDUxLTFjMDMtNGU1OS1iYTBjLTJiNDU2OTVlZjUzNTpScF9kUmR4M0psTmVvZjU3V01hTTJOTkFaVkxVeFVCdEhZRzJOZ1BzVkJ3IiwidHlwIjoiQmVhcmVyIiwiYXpwIjoic2hpcHgiLCJzZXNzaW9uX3N0YXRlIjoiZDc5OGM3MzEtN2ZmNi00YTU0LWI0ZWItMmUwNjkwOWFlNTdkIiwic2NvcGUiOiJvcGVuaWQgYXBpOmFwaXBvaW50cyIsInNpZCI6ImQ3OThjNzMxLTdmZjYtNGE1NC1iNGViLTJlMDY5MDlhZTU3ZCIsImFsbG93ZWRfcmVmZXJyZXJzIjoia3VuY3JvZy50ZXN0IiwidXVpZCI6IjQ3Yzg0YTE5LWI0MTMtNDk5ZC04ZWUxLWFiOTE1MDQ1YzZiMiJ9.ZAXfMv-qOG81mgJ6WxMZGKgn_dVsASp8RI49VAYsJIAZWmQmQxr7WJ3H5_BNn8KCxOwj-HL2UMN1yEWTWZzCul8EtNawPwkB6SKiyx8Z63IRymLuYJn2JCx0_GZCjzQjxW3WVwIebMm3yMqhFQfDdyEW5AOQkfZk-X7y-fjZJLZNDKVX9aIVi9LV8Zdd3B0PlKHsBGtRsBiuJX_4FPsPYLdRQoNLDElesQF2Q_73SSdAXbSZElCsTwFtdNiJ9jQcC-3VvFesHV0ob9LIr8WEFuWrIh192TzdzmOOk2ZzAUihm-5Fuzpm9Dep3PmLUN-akEjON6chmfEzRkkRRM4mAg"
                    config="parcelCollect">
                </inpost-geowidget>
            </div>
        </div>

    </div>


@endsection
<script type="text/javascript" data-url="{{ url('/cart') }}">
    @yield('javascript')
</script>
@section('js-files')
    @vite('resources/js/delete.js')
    @vite(['resources/js/checkout.js'])
    @vite('resources/css/checkout.css')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const shippingRadios = document.querySelectorAll('input[name="id_shipping_method"]');
            const inpostSection = document.getElementById('inpost-section');
            const lockerInput = document.getElementById('inpostLocker');
            const lockerInfo = document.getElementById('lockerInfo');
            const modal = document.getElementById('inpostModal');
            const openModalBtn = document.getElementById('openInpostModal');
            const closeModalBtn = document.querySelector(".inpost-close");
            const geo = document.getElementById('inpost-geowidget');

            if (!openModalBtn || !modal) return;

            // otwieranie modala
            openModalBtn.addEventListener("click", () => {
                modal.style.display = "flex";
                document.body.classList.add("modal-open"); // 🔒 blokada scrolla
            });

            // zamykanie modala (krzyżyk)
            closeModalBtn.addEventListener("click", () => {
                modal.style.display = "none";
                document.body.classList.remove("modal-open"); // 🔓 przywrócenie scrolla
            });

            // zamykanie po kliknięciu poza mapą
            window.addEventListener("click", (e) => {
                if (e.target === modal) {
                    modal.style.display = "none";
                    document.body.classList.remove("modal-open");
                }
            });

            // Pokaż sekcję tylko przy metodzie InPost
            shippingRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const labelText = this.closest('label').innerText.toLowerCase();

                    if (labelText.includes('inpost')) {
                        inpostSection.style.display = 'block';
                    } else {
                        inpostSection.style.display = 'none';
                        lockerInfo.textContent = '';
                        lockerInput.value = '';
                    }
                });
            });

            // Otwieranie i zamykanie modala
            openModalBtn.addEventListener('click', () => modal.style.display = 'block');
            closeModalBtn.addEventListener('click', () => modal.style.display = 'none');
            window.addEventListener('click', (e) => {
                if (e.target === modal) modal.style.display = 'none';
            });

            // Po wybraniu paczkomatu
            geo.addEventListener('onpointselect', (event) => {
                const point = event.detail;
                lockerInput.value = point.name;
                lockerInfo.textContent = 'Wybrano paczkomat: ' + point.name;
                modal.style.display = 'none';
            });
        });
    </script>

@endsection
