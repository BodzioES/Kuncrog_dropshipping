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
        .details, .items {
            width: 100%;
            border-collapse: collapse;
        }
        .details td {
            padding: 4px 6px;
        }
        .items th, .items td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: left;
        }
        .items th {
            background: #f2f2f2;
        }
        .totals {
            margin-top: 10px;
            width: 100%;
            border-collapse: collapse;
        }
        .totals td {
            padding: 6px 8px;
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
            <div><strong>Data:</strong> </div>
        </div>
    </div>

    <div class="section">
        <table class="details">
            <tr>
                <td style="vertical-align: top; width: 50%;">
                    <strong>Do:</strong><br>

                </td>
                <td style="vertical-align: top; width: 50%;">
                    <strong>Płatność:</strong><br>
                    <br>
                    <strong>Dostawa:</strong><br>

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

            </tbody>
        </table>
    </div>

    <div class="section">
        <table class="totals">
            <tr>
                <td style="width: 70%;"><strong>Razem produkty:</strong></td>
                <td class="text-right">} zł</td>
            </tr>
            <tr>
                <td><strong>Dostawa:</strong></td>
                <td class="text-right"> zł</td>
            </tr>
            <tr style="font-size: 14px;">
                <td><strong>Łącznie:</strong></td>
                <td class="text-right"><strong>{ zł</strong></td>
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
