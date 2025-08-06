<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Faktura</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 25px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 20px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .invoice-meta {
            text-align: right;
        }
        .section {
            margin-bottom: 15px;
        }
        .section h3 {
            margin-bottom: 8px;
            font-size: 16px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 4px;
        }
        .details, .items, .totals {
            width: 100%;
            border-collapse: collapse;
        }
        .details td {
            padding: 4px 6px;
        }
        .items th, .items td, .totals td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: left;
        }
        .items th {
            background: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 40px;
            font-size: 10px;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 8px;
            color: #666;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">Kuncrog</div>
        <div class="invoice-meta">
            <div><strong>Numer zamówienia:</strong> {{$order->id}}#</div>
            <div><strong>Data:</strong> {{$order->created_at}} </div>
        </div>
    </div>

    <div class="section">
        <table class="details">
            <tr>
                <td style="vertical-align: top; width: 50%;">
                    <strong>Do:</strong><br>
                    {{$order->address->first_name}} {{$order->address->last_name}}<br>
                    {{$order->address->street_and_house_number}}<br>
                    {{$order->address->email}}<br>
                    {{$order->address->phone_number}}
                </td>
                <td style="vertical-align: top; width: 50%;">
                    <strong>Płatność:</strong><br>
                    {{$order->paymentMethod->name}}<br><br>
                    <strong>Dostawa:</strong><br>
                    {{$order->shippingMethod->name}}
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>Produkty</h3>
        <table class="items">
            <thead>
            <tr>
                <th>Nazwa</th>
                <th>Ilość</th>
                <th>Cena jednostkowa</th>
                <th>Wartość</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                @php
                    $totalProductPrice = $item->quantity * $item->current_price;
                @endphp
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->current_price, 2, ',', ' ') }} zł</td>
                    <td>{{ number_format($totalProductPrice, 2, ',', ' ') }} zł</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <table class="totals">
            <tr>
                <td colspan="3" class="text-right"><strong>Razem za produkty:</strong></td>
                <td>
                    <strong>
                        {{ number_format($order->items->sum(function($item) {
                            return $item->quantity * $item->current_price;
                        }), 2, ',', ' ') }} zł
                    </strong>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-right"><strong>Dostawa:</strong></td>
                <td class="text-right">{{ number_format($order->shippingMethod->price, 2, ',', ' ') }} zł</td>
            </tr>
            <tr style="font-size: 14px;">
                <td colspan="3" class="text-right"><strong>Łącznie:</strong></td>
                <td class="text-right"><strong>{{ number_format($order->total_price + $order->shippingMethod->price, 2, ',',' ') }} zł</strong></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Kuncrog • ul. Przykładowa 1 • 00-001 Warszawa • email: kontakt@kuncrog.pl • NIP: 123-456-78-90<br>
        Dziękujemy za zakupy! Jeśli masz pytania, skontaktuj się z obsługą klienta.
    </div>
</div>
</body>
</html>
