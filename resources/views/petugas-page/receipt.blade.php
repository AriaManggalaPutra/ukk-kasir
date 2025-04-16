<x-layout>
    <div class="container my-5">
        <div class="bg-white shadow rounded p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('pembelian.print', $order->id) }}" target="_blank" class="btn btn-primary me-2">Unduh</a>
                    <a href="" class="btn btn-secondary">Kembali</a>
                </div>
                <div class="text-end">
                    <p class="mb-0">Invoice – #{{ $order->id }}</p>
                    <small>{{ $order->created_at->translatedFormat('d F Y') }}</small>
                </div>
            </div>

            {{-- Info Member (hanya jika customer adalah member) --}}
            @if ($order->customer && $order->customer->phone)
                <div class="mb-4">
                    <div><strong>{{ $order->customer->phone }}</strong></div>
                    <div>MEMBER SEJAK :
                        {{ \Carbon\Carbon::parse($order->customer->created_at)->translatedFormat('d F Y') }}</div>
                    <div>MEMBER POIN : {{ number_format($order->customer->points, 0, ',', '.') }}</div>
                </div>
            @endif




            {{-- Tabel Produk --}}
            <table class="table table-borderless">
                <thead class="border-bottom">
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Quantity</th>
                        <th class="text-end">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $detail)
                        <tr>
                            <td>{{ $detail->product->product_name }}</td>
                            <td>Rp. {{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td class="text-end">Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Ringkasan Pembayaran --}}
            <div class="row mt-4 align-items-center bg-light p-3 rounded">
                <div class="col-md-3">
                    <div class="text-muted small">POIN DIGUNAKAN</div>
                    <div class="fw-bold fs-5">{{ number_format($order->discount, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small">KASIR</div>
                    <div class="fw-bold fs-5">{{ $order->user->name ?? 'Petugas' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small">KEMBALIAN</div>
                    <div class="fw-bold fs-5">Rp. {{ number_format($order->change, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small">TOTAL BAYAR</div>
                    <div class="fw-bold fs-5">Rp. {{ number_format($order->amount_paid, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-3 bg-dark text-white p-3 mt-5 rounded text-end">
                    <div class="text-uppercase small">Total</div>

                    @php
                        // Hitung total sebelum diskon
                        $totalBeforeDiscount = $order->orderDetails->sum(function ($item) {
                            return $item->unit_price * $item->quantity;
                        });
                    @endphp

                    @if ($order->customer && $order->discount > 0)
                        {{-- Harga sebelum diskon dicoret --}}
                        <div class="fs-6 text-decoration-line-through mb-1">
                            Rp. {{ number_format($totalBeforeDiscount, 0, ',', '.') }}
                        </div>
                    @endif

                    {{-- Harga akhir --}}
                    <div class="fs-4 fw-bold">
                        Rp. {{ number_format($order->final_price, 0, ',', '.') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layout>
