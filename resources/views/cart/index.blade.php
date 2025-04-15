@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Twój koszyk</h2>
        <table class="table">
            <thead>
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
                        <img src="{{ $isGuest ? $item['image'] : $item->image }}" width="50" alt="photo">
                    </td>
                    <td>{{ $isGuest ? $item['name'] : $item->name }}</td>
                    <td>{{ $isGuest ? $item['price'] : $item->price }} zł</td>
                    <td>{{ $isGuest ? $item['quantity'] : $item->quantity }}</td>
                    <td>
                        <button class="btn btn-danger delete" data-id="{{ $isGuest ? $item['id'] : $item->id }}">
                            USUN
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
<script type="text/javascript" data-url="{{ url('/cart') }}">
    @yield('javascript')
</script>
@vite('resources/js/delete.js')
