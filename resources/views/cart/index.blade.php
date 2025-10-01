@extends('layouts.app')

@section('content')
    <div class="container cart-container">
        <h2 class="text-center mb-4">Your cart</h2>

        @if(count($cartItems) > 0)
            {{--  Desktop: koszyk  --}}
            <div class="cart-table-wrapper d-none d-md-block">
                <table class="table cart-table align-middle">
                    <thead class="thead-light">
                    <tr>
                        <th>Photo</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>
                                {{--  !!! Operator .konkatenacji ma wyższy priorytet niż operator trójargumentowy ?:
                                  czyli bez nawiasow wykona sie 1 albo 0
                                  czyli cos takiego ( asset('storage/products/' . $isGuest) ) ? $item['image'] : $item->image
                                  po prostu bez nawiasow sprawdza czy jest gosciem czy nie i zostawia reszte kodu w sensie go nie czyta --}}
                                <img src="{{ asset('storage/products/' . ($isGuest ? $item['image'] : $item->image)) }}" alt="Photo"
                                    style="width: 80px; height: auto;"
                                >
                            </td>
                            <td>{{ $isGuest ? $item['name'] : $item->name }}</td>
                            <td>{{ $isGuest ? $item['price'] : $item->price }} zł</td>
                            <td>x{{ $isGuest ? $item['quantity'] : $item->quantity }}</td>
                            <td>
                                <button class="btn btn-danger delete" data-id="{{ $isGuest ? $item['id'] : $item->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{--  Mobile: koszyk  --}}

            <div class="cart-mobile d-block d-md-none">
                @foreach($cartItems as $item)
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <img src="{{asset('storage/products/' . ($isGuest ? $item['image'] : $item->image))}}"
                                 alt="Photo" style="width: 60px; height: auto; margin-right: 10px;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $isGuest ? $item['name'] : $item->name }}</h6>
                                <div class="small text-muted mb-1">
                                    Price: {{ $isGuest ? $item['price'] : $item->price }} zł
                                </div>
                                <div class="small text-muted mb-1">
                                    Quanity: x{{ $isGuest ? $item['quantity'] : $item->quantity }}
                                </div>
                            </div>
                            <button class="btn btn-sm btn-danger delete ms-2"
                                    data-id="{{ $isGuest ? $item['id'] : $item->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="button-wrapper mt-4">
                <a class="checkout-button" href="{{ route('checkout.index') }}">
                    <button type="button" class="btn btn-outline-success">
                        Go to summary
                    </button>
                </a>
            </div>

        @else
            <p class="text-center mt-5 fs-4">Your cart is empty 🛒</p>
        @endif
    </div>
@endsection

<script type="text/javascript" data-url="{{ url('/cart') }}">
    @yield('javascript')
</script>
@vite('resources/js/delete.js')
@vite('resources/css/cart.css')


