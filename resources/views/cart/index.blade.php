@extends('layouts.app')

@section('content')
    <div class="container cart-container">
        <h2 class="text-center mb-4">Twój koszyk</h2>

        @if(count($cartItems) > 0)
            <div class="cart-table-wrapper">
                <table class="table cart-table">
                    <thead class="thead-light">
                    <tr>
                        <th>Zdjęcie</th>
                        <th>Produkt</th>
                        <th>Cena</th>
                        <th>Ilość</th>
                        <th>Akcje</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>
                                <img src={{--{{ $isGuest ? $item['image'] : $item->image }}--}}"https://dummyimage.com/300x240/fc00fc/000000.jpg&text=image" width="60" alt="photo">
                            </td>
                            <td>{{ $isGuest ? $item['name'] : $item->name }}</td>
                            <td>{{ $isGuest ? $item['price'] : $item->price }} zł</td>
                            <td>{{ $isGuest ? $item['quantity'] : $item->quantity }}</td>
                            <td>
                                <button class="btn btn-danger delete" data-id="{{ $isGuest ? $item['id'] : $item->id }}">
                                    USUŃ
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="button-wrapper mt-4">
                <a class="checkout-button" href="{{ route('checkout.index') }}">
                    <button type="button" class="btn btn-outline-success">
                        Przejdź do podsumowania
                    </button>
                </a>
            </div>

        @else
            <p class="text-center mt-5 fs-4">Twój koszyk jest pusty 🛒</p>
        @endif
    </div>
@endsection

<script type="text/javascript" data-url="{{ url('/cart') }}">
    @yield('javascript')
</script>
@vite('resources/js/delete.js')
@vite('resources/css/cart.css')


