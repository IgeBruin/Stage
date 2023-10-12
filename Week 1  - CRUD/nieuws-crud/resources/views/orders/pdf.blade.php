
<!DOCTYPE html>
<html>
<head>
    <title>Factuur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            margin: 20px;
        }
        .invoice {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-header h1 {
            color: #333;
        }
        .invoice-details {
            font-size: 12px;
            margin-top: 10px;
        }
        .invoice-details p {
            margin: 3px;
        }
        .invoice-items {
            margin-top: 20px;
        }
        .invoice-items table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-items th, .invoice-items td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        .invoice-total {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="invoice">
            <div class="invoice-header">
                <h1>Factuur</h1>
            </div>
            <div class="invoice-details">
                @if ($address)
                    <p><strong>Naam:</strong> {{ $address->name }} {{ $address->surname }}</p>
                    <p><strong>Straat:</strong> {{ $address->street }} {{ $address->street_number }}</p>
                    <p><strong>Postcode:</strong> {{ $address->zip_code }}</p>
                    <p><strong>Plaats:</strong> {{ $address->city }}</p>
                @endif
            </div>
            <div class="invoice-items">
                <table>
                    <thead>
                        <tr>
                            <th>Naam</th>
                            <th>Prijs</th>
                            <th>Aantal</th>
                            <th>Subtotaal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartData['products'] as $product)
                            <tr>
                                <td>{{ $product['name'] }}</td>
                                <td>{{ $product['price'] }}</td>
                                <td>{{ $product['quantity'] }}</td>
                                <td>{{ $product['subtotal'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="invoice-total">
                <p><strong>Totaal exclusief BTW:</strong> {{ number_format($cartData['totalCartPrice'],2) }}</p>
                <p><strong>BTW:</strong> {{ number_format($cartData['totalVat'],2) }}</p>
                <p><strong>Totaal inclusief BTW:</strong> {{ number_format($cartData['totalCartPrice'] + $cartData['totalVat'],2) }}</p>
            </div>
        </div>
    </div>
</body>
</html>
