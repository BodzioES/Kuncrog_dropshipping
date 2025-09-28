<div style="background-color: #2f2f2f; font-family: Arial, sans-serif; padding: 30px;">
    <div style="max-width: 700px; margin: 0 auto; background-color: #fff; padding: 30px; border-radius: 8px;">
        <div style="text-align: left; padding-bottom: 20px;">
           <h1>Kuncrog</h1>
        </div>

        <h2 style="margin-bottom: 10px;">Your order has been confirmed!</h2>
        <p style="margin-bottom: 20px;">Hello there, {{ $order->address->first_name }}!<br>
            Your order has been accepted and will be shipped within the next two days.</p>

        <hr style="margin: 20px 0;">

        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="padding: 5px 0;"><strong>Order date:</strong></td>
                <td>{{ $order->created_at->format('d M, Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Order number:</strong></td>
                <td>{{ $order->id }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Payment method:</strong></td>
                <td>{{ $order->paymentMethod->name }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0;"><strong>Delivery address:</strong></td>
                <td>{{ $order->address->street_and_house_number }}, {{ $order->address->postal_code }} {{ $order->address->city }}</td>
            </tr>
        </table>

        <h4 style="margin-top: 30px;">Ordered products</h4>
        <table style="width: 100%; margin-bottom: 20px; border-collapse: collapse;">
            @foreach($order->items as $item)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td>
                        <img src="{{ url('storage/products/' . $item->product->images->first()->image_url) }}"
                             alt="photo"
                             width="50"
                        >
                    </td>
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
                <td><strong>Total amount of products:</strong></td>
                <td style="text-align: right;">{{ number_format($totalPrice, 2) }} zł</td>
            </tr>
            <tr>
                <td><strong>Delivery ({{ $order->shippingMethod->name }}):</strong></td>
                <td style="text-align: right;">{{ number_format($order->shippingMethod->price, 2) }} zł</td>
            </tr>
            <tr style="border-top: 2px solid #000;">
                <td style="padding-top: 10px;"><strong>Grand total:</strong></td>
                <td style="text-align: right; padding-top: 10px;">
                    {{ number_format($totalPrice + $order->shippingMethod->price, 2) }} zł
                </td>
            </tr>
        </table>

        <p style="margin-top: 30px;">Thank you for shopping in our store!<br>
            You will receive a shipping notification when your package has shipped.</p>

        <p style="margin-top: 30px;"><strong>Zespół Kuncrog</strong></p>

        <hr style="margin-top: 40px;">
        <p style="font-size: 12px; color: #888;">Need help? Visit our <a href="#" style="color: #444;">help center</a></p>
    </div>
</div>
