<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .no-border td { border: none; }
        .summary { margin-top: 20px; }
    </style>
</head>
<body>
    <h3>Kasir Application</h3>

    @php
    $isMember = $order->customer && $order->customer->phone;
    @endphp

<p>
    Member Status: {{ $isMember ? 'Member' : 'Bukan Member' }}<br>
    No. HP: {{ $isMember ? $order->customer->phone : '-' }}<br>
    Bergabung Sejak: {{ $isMember ? \Carbon\Carbon::parse($order->customer->created_at)->translatedFormat('d F Y') : '-' }}<br>
    Poin Member: {{ $isMember ? number_format($order->customer->points, 0, ',', '.') : '-' }}
</p>  

    <table>
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th>Nama Produk</th>
                <th>QTY</th>
                <th>Harga</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderDetails as $item)
            <tr>
                <td>{{ $item->product->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp. {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary no-border">
        <tr>
            <td><strong>Total Harga</strong></td>
            <td class="text-end">Rp. {{ number_format($order->orderDetails->sum('subtotal'), 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Poin Digunakan</strong></td>
            <td class="text-end">{{ number_format($order->discount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Yang Di Bayarkan</strong></td>
            <td class="text-end">Rp. {{ number_format($order->amount_paid, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Harga Setelah Poin</strong></td>
            <td class="text-end">Rp. {{ number_format($order->final_price, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Kembalian</strong></td>
            <td class="text-end">Rp. {{ number_format($order->change, 0, ',', '.') }}</td>
        </tr>
    </table>

    <p class="text-center" style="margin-top: 20px;">
        {{ $order->created_at }} | {{ $order->user->name ?? 'Petugas' }}<br>
        <strong>Terima kasih atas pembelian Anda!</strong>
    </p>
</body>
</html>
