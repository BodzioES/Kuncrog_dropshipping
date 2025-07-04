@if ($cartItems->isEmpty())
    <p>Twój koszyk jest pusty.</p>
@else
    <table class="table">
        <thead>
        <tr>
            <th>Produkt</th>
            <th>Ilość</th>
            <th>Cena</th>
            <th>Łącznie</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($cartItems as $item)
            <tr>
                <td>{{ $item->product->name ?? $item['name'] }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->product->price ?? $item['price'], 2) }} PLN</td>
                <td>{{ number_format(($item->product->price ?? $item['price']) * $item->quantity, 2) }} PLN</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
