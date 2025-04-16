<x-layout>
    <div class="pagetitle">
        <h1>Halaman Member</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('petugas.store') }}">Pembayaran</a></li>
                <li class="breadcrumb-item active">Halaman Member</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-body p-4">
                <div class="row">
                    {{-- Kiri: Produk --}}
                    <div class="col-md-6">
                        <table class="table table-bordered mb-4">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productDetails as $item)
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['jumlah'] }}</td>
                                        <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="text-end fw-bold">
                            <p>Total Harga: Rp. {{ number_format($transactionData['total_price'], 0, ',', '.') }}</p>
                            <p>Total Bayar: Rp. {{ number_format($transactionData['amount_paid'], 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Kanan: Form Member --}}
                    <div class="col-md-6">
                        <form method="POST" action="{{ route('member.verify') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nama Member</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $memberName ?? '' }}" placeholder="Masukkan nama member" required>
                            </div>

                            <div class="mb-3">
                                
                                <input type="hidden" name="phone" id="phone" value="{{ $transactionData['phone'] ?? '' }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Poin (setelah transaksi)</label>
                                <input type="text" value="{{ $transactionData['member_points'] }}"
                                    readonly class="form-control bg-light text-muted">
                            </div>

                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" name="use_points" id="use_points"
                                    {{ $isReturningCustomer ? '' : 'disabled' }}>
                                <label class="form-check-label" for="use_points">Gunakan poin</label>
                            </div>

                            @if (!$isReturningCustomer)
                                <div class="mb-3 text-danger small">
                                    Poin tidak dapat digunakan pada pembelanjaan pertama.
                                </div>
                            @endif

                            <input type="hidden" name="is_new" value="{{ isset($memberName) ? 'false' : 'true' }}">

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Selanjutnya</button>
                            </div>
                        </form>
                    </div>
                </div> {{-- row --}}
            </div>
        </div>
    </section>
</x-layout>
