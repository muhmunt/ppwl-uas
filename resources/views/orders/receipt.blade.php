<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Pesanan - {{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .info {
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .total {
            border-top: 2px dashed #000;
            padding-top: 10px;
            margin-top: 10px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px dashed #000;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ config('app.name') }}</h2>
        <p>Struk Pesanan</p>
    </div>

    <div class="info">
        <p><strong>No. Pesanan:</strong> {{ $order->order_number }}</p>
        <p><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
        @if($order->customer_name)
            <p><strong>Pelanggan:</strong> {{ $order->customer_name }}</p>
        @endif
        @if($order->table_number)
            <p><strong>Meja:</strong> {{ $order->table_number }}</p>
        @endif
        <p><strong>Kasir:</strong> {{ $order->user->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->menu->name }}</td>
                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <div style="display: flex; justify-content: space-between;">
            <span>TOTAL:</span>
            <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>
    </div>

    @if($order->notes)
        <div class="info">
            <p><strong>Catatan:</strong> {{ $order->notes }}</p>
        </div>
    @endif

    <div class="footer">
        <p>Terima kasih atas kunjungan Anda!</p>
        <p>{{ $order->created_at->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
