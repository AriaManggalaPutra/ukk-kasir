<x-layouts>

    <!DOCTYPE html>
    <html dir="ltr" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex,nofollow">
        <title>Produk - IndoApril</title>
        <link rel="icon" type="image/png" sizes="16x16"
            href="http://45.64.100.26:88/ukk-kasir/public/assets/images/favicon.png">
        <link href="http://45.64.100.26:88/ukk-kasir/public/assets/libs/chartist/dist/chartist.min.css"
            rel="stylesheet">
        <link
            href="http://45.64.100.26:88/ukk-kasir/public/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css"
            rel="stylesheet">
        <link href="http://45.64.100.26:88/ukk-kasir/public/dist/css/style.min.css" rel="stylesheet">
        <link rel="stylesheet" href="http://45.64.100.26:88/ukk-kasir/public/plugins/swal2.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    </head>

    <body>

        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 d-flex align-items-center">
                                <li class="breadcrumb-item"><a href="index.html" class="link"><i
                                            class="mdi mdi-home-outline fs-4"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Produk</li>
                            </ol>
                        </nav>
                        <h1 class="mb-0 fw-bold">Produk</h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row justify-content-end">
                                    <div class="col text-end">
                                        <a href="{{ route('admin-create-product') }}" class="btn btn-primary">
                                            Tambah Produk
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Gambar</th>
                                                <th scope="col">Nama Produk</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Stok</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $index => $product)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td><img src="{{ asset('storage/' . $product->product_image) }}"
                                                            width="50" height="50"
                                                            style="object-fit:cover; border-radius:5px;"></td>
                                                    <td>{{ $product->product_name }}</td>
                                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                                    <td>{{ $product->stock }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-between">
                                                            <a href="{{ route('product.edit', $product->id) }}"
                                                                class="btn btn-warning btn-sm">Edit</a>
                                                            <button type="button" class="btn btn-info btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#updateStockModal"
                                                                data-id = "{{ $product->id }}"
                                                                data-name = "{{ $product->product_name }}"
                                                                data-stock = "{{ $product->stock }}">
                                                                Update Stock
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-bs-toggle="modal" data-bs-target= "#deleteModal"
                                                                data-id = "{{ $product->id }}"
                                                                data-name = "{{ $product->product_name }}"
                                                                data-has-order="{{ $product->orderDetails->count() > 0 ? 'true' : 'false' }}">
                                                                Hapus
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <x-product.modal-delete></x-product.modal-delete>
        <x-product.modal-update-stock></x-product.modal-update-stock>

        <script>
            $(document).ready(function() {
                $('#salesTable').DataTable({
                    "language": {
                        "emptyTable": "Tidak ada data tersedia",
                        "search": "Cari:",
                        "lengthMenu": "Tampilkan _MENU_ entri",
                        "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                        "infoEmpty": "Menampilkan 0 hingga 0 dari 0 entri",
                        "paginate": {
                            "first": "Pertama",
                            "last": "Terakhir",
                            "next": "Selanjutnya",
                            "previous": "Sebelumnya"
                        }
                    }
                });
            });
        </script>
        <script>
            function notif(type, msg) {
                Swal.fire({
                    icon: type,
                    text: msg
                })
            }
        </script>
        <script>
            function HitData(urlPost, dataPost, typePost) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: urlPost,
                        data: dataPost,
                        type: typePost,
                        headers: {
                            'X-CSRF-TOKEN': "KgxUl4UTpYJX79XyGMFF09dHfSkQEJ6iHwGtBTP5"
                        },
                        success: (response) => {
                            resolve(response)
                        },
                        error: (error) => {
                            reject(error)
                        }
                    })
                })
            }
        </script>
    </body>

    </html>

</x-layout>
