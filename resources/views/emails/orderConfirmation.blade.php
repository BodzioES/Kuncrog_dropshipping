<div style="background-color: #2f2f2f; font-family: Arial, sans-serif; padding: 30px;">
    <div style="max-width: 700px; margin: 0 auto; background-color: #fff; padding: 30px; border-radius: 8px;">
        <div style="text-align: left; padding-bottom: 20px;">
            <img src="https://dummyimage.com/300x240/fc00fc/000000.jpg&text=image" width="50" alt="Logo">
        </div>

        <h2 style="margin-bottom: 10px;">Twoje zamówienie zostało potwierdzone!</h2>
        <p style="margin-bottom: 20px;">Witaj, {{ $order->address->first_name }}!<br>
            Twoje zamówienie zostało przyjęte i zostanie wysłane w ciągu najbliższych dwóch dni.</p>

        <hr style="margin: 20px 0;">

        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="padding: 5px 0;"><strong>Data zamówienia:</strong></td>
                <td>{{ $order->created_at->format('d M, Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Numer zamówienia:</strong></td>
                <td>{{ $order->id }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Metoda płatności:</strong></td>
                <td>{{ $order->paymentMethod->name }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Adres dostawy:</strong></td>
                <td>{{ $order->address->street_and_house_number }}, {{ $order->address->postal_code }} {{ $order->address->city }}</td>
            </tr>
        </table>

        <h4 style="margin-top: 30px;">Zamówione produkty</h4>
        <table style="width: 100%; margin-bottom: 20px; border-collapse: collapse;">
            @foreach($order->items as $item)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 10px 0; width: 60%;">
                        <strong>{{ $item->product->name }}</strong><br>
                        Ilość: {{ $item->quantity }}
                    </td>
                    <td style="text-align: right; padding: 10px 0;">
                        {{ number_format($item->product->price * $item->quantity, 2) }} zł
                    </td>
                </tr>
            @endforeach
        </table>

        @php
            $totalPrice = 0;
            foreach($order->items as $item) {
                $totalPrice += $item->product->price * $item->quantity;
            }
        @endphp

        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td><strong>Łączna kwota produktów:</strong></td>
                <td style="text-align: right;">{{ number_format($totalPrice, 2) }} zł</td>
            </tr>
            <tr>
                <td><strong>Dostawa ({{ $order->shippingMethod->name }}):</strong></td>
                <td style="text-align: right;">{{ number_format($order->shippingMethod->price, 2) }} zł</td>
            </tr>
            <tr style="border-top: 2px solid #000;">
                <td style="padding-top: 10px;"><strong>Suma całkowita:</strong></td>
                <td style="text-align: right; padding-top: 10px;">
                    {{ number_format($totalPrice + $order->shippingMethod->price, 2) }} zł
                </td>
            </tr>
        </table>

        <p style="margin-top: 30px;">Dziękujemy za zakupy w naszym sklepie!<br>
            Powiadomienie o wysyłce otrzymasz, gdy przesyłka zostanie nadana.</p>

        <p style="margin-top: 30px;"><strong>Zespół Kuncrog</strong></p>

        <hr style="margin-top: 40px;">
        <p style="font-size: 12px; color: #888;">Potrzebujesz pomocy? Odwiedź nasze <a href="#" style="color: #444;">centrum pomocy</a></p>
    </div>
</div>
