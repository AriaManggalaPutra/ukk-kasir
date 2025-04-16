<x-layout>
    <div class="pagetitle">
        <h1>Halaman Penjualan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('petugas.pembelian') }}">Penjualan</a></li>
                <li class="breadcrumb-item active">Daftar penjualan</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-body p-1">
            <div class="container mt-4">
                <form action="{{ route('admin-penjualan') }}" method="GET" id="filterForm">
                    <div class="row g-3 align-items-end">
                        <!-- Select Jenis Filter -->
                        <div class="col-md-3">
                            <label for="filter_type" class="form-label">Jenis Filter</label>
                            <select name="filter_type" id="filter_type" class="form-select">
                                <option value="date" {{ request('filter_type') == 'date' ? 'selected' : '' }}>Tanggal Spesifik</option>
                                <option value="day" {{ request('filter_type') == 'day' ? 'selected' : '' }}>Hari</option>
                                <option value="month" {{ request('filter_type') == 'month' ? 'selected' : '' }}>Bulan</option>
                                <option value="year" {{ request('filter_type') == 'year' ? 'selected' : '' }}>Tahun</option>
                            </select>
                        </div>

                        <!-- Filter Tanggal Spesifik -->
                        <div class="col-md-3" id="filter_date" style="display: {{ request('filter_type') == 'date' ? 'block' : 'none' }};">
                            <label for="date" class="form-label">Pilih Tanggal</label>
                            <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                        </div>

                        <!-- Filter Hari -->
                        <div class="col-md-3" id="filter_day" style="display: {{ request('filter_type') == 'day' ? 'block' : 'none' }};">
                            <label for="day" class="form-label">Pilih Hari (1-31)</label>
                            <input type="number" name="day" id="day" class="form-control" min="1" max="31" value="{{ request('day') }}">
                        </div>

                        <!-- Filter Bulan -->
                        <div class="col-md-3" id="filter_month" style="display: {{ request('filter_type') == 'month' ? 'block' : 'none' }};">
                            <label for="month" class="form-label">Pilih Bulan</label>
                            <select name="month" id="month" class="form-select">
                                <option value="">Pilih Bulan</option>
                                <option value="1" {{ request('month') == '1' ? 'selected' : '' }}>Januari</option>
                                <option value="2" {{ request('month') == '2' ? 'selected' : '' }}>Februari</option>
                                <option value="3" {{ request('month') == '3' ? 'selected' : '' }}>Maret</option>
                                <option value="4" {{ request('month') == '4' ? 'selected' : '' }}>April</option>
                                <option value="5" {{ request('month') == '5' ? 'selected' : '' }}>Mei</option>
                                <option value="6" {{ request('month') == '6' ? 'selected' : '' }}>Juni</option>
                                <option value="7" {{ request('month') == '7' ? 'selected' : '' }}>Juli</option>
                                <option value="8" {{ request('month') == '8' ? 'selected' : '' }}>Agustus</option>
                                <option value="9" {{ request('month') == '9' ? 'selected' : '' }}>September</option>
                                <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>Oktober</option>
                                <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>November</option>
                                <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>Desember</option>
                            </select>
                        </div>

                        <!-- Filter Tahun -->
                        <div class="col-md-3" id="filter_year" style="display: {{ request('filter_type') == 'year' ? 'block' : 'none' }};">
                            <label for="year" class="form-label">Pilih Tahun</label>
                            <input type="number" name="year" id="year" class="form-control" min="2000" max="{{ date('Y') }}" value="{{ request('year') ?? date('Y') }}">
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            @if(request()->has('filter_type'))
                                <a href="{{ route('admin-penjualan') }}" class="btn btn-secondary">Reset</a>
                            @endif
                        </div>
                    </div>
                </form>

                <div class="table-responsive mt-4">
                    <table id="penjualanTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Tanggal Penjualan</th>
                                <th>Total Harga</th>
                                <th>Koin</th>
                                <th>Dibuat Oleh</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $index => $order)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $order->customer->name ?? 'NON–MEMBER' }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td>Rp. {{ number_format($order->final_price, 0, ',', '.') }}</td>
                                    <td>{{ $order->customer->points ?? '0' }}</td>
                                    <td>{{ $order->createdBy->name ?? 'Petugas' }}</td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal-{{ $order->id }}">
                                            Lihat
                                        </button>
                                        <a href="{{ route('pembelian.print', $order->id) }}" class="btn btn-primary btn-sm">Unduh Bukti</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Button Export Excel -->
<div class="mt-3">
    <form action="{{ route('penjualan.export') }}" method="GET">
        <!-- Sertakan parameter filter yang aktif -->
        @if(request('filter_type') == 'date')
            <input type="hidden" name="date" value="{{ request('date') }}">
            <input type="hidden" name="filter_type" value="date">
        @elseif(request('filter_type') == 'day')
            <input type="hidden" name="day" value="{{ request('day') }}">
            <input type="hidden" name="filter_type" value="day">
        @elseif(request('filter_type') == 'month')
            <input type="hidden" name="month" value="{{ request('month') }}">
            <input type="hidden" name="filter_type" value="month">
        @elseif(request('filter_type') == 'year')
            <input type="hidden" name="year" value="{{ request('year') }}">
            <input type="hidden" name="filter_type" value="year">
        @endif
        
        <button type="submit" class="btn btn-success">Export Excel</button>
    </form>
</div>
            </div>
        </div>
    </div>

    @foreach ($orders as $order)
        <x-detail-penjualan :order="$order" />
    @endforeach

    @push('scripts')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#penjualanTable').DataTable();

                // Tampilkan field filter sesuai pilihan
                $('#filter_type').on('change', function () {
                    const selected = $(this).val();
                    
                    // Sembunyikan semua field filter
                    $('#filter_date, #filter_day, #filter_month, #filter_year').hide();
                    
                    // Reset nilai filter
                    $('#date, #day, #month, #year').val('');
                    
                    // Tampilkan field yang sesuai
                    if (selected === 'date') {
                        $('#filter_date').show();
                    } else if (selected === 'day') {
                        $('#filter_day').show();
                    } else if (selected === 'month') {
                        $('#filter_month').show();
                    } else if (selected === 'year') {
                        $('#filter_year').show();
                    }
                });
            });
        </script>
    @endpush
</x-layout>
