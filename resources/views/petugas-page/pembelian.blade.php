<x-layout>
    <div class="pagetitle">
        <h1>Halaman Penjualan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('petugas.pembelian')}}">Penjualan</a></li>
                <li class="breadcrumb-item active"> Daftar penjualan</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-body p-1">
            <div class="container mt-4">
                <div class="d-flex justify-content-between mb-3">
                    <a href="" style="height: 40px;" class="btn btn-success">Export Penjualan (.xlsx)</a>
                    <x-add-button route="petugas.pembelian.formInput" buttonText="Tambah Penjualan" />
                </div>

                <div class="table-responsive">
                    <table id="penjualanTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Tanggal Penjualan</th>
                                <th>Total Harga</th>
                                <th>Koin</th>
                                <th>Dibuat Oleh</th>
                                <th class="text-end"></th>
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
                                    <td>Petugas</td>
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
            });
        </script>
    @endpush
</x-layout>
