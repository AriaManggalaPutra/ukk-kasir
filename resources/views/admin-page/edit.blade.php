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
                                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}" class="link"><i
                                            class="mdi mdi-home-outline fs-4"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Produk</li>
                            </ol>
                        </nav>
                        <h1 class="mb-0 fw-bold">Edit Produk</h1>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form class="form-horizontal form-material mx-2"
                                    action="{{ route('product.update', $products->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="ket" value="edit">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12">Nama Produk <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" name="product_name"
                                                        value="{{ old('product_name', $products->product_name) }}"
                                                        class="form-control form-control-line">
                                                    @error('product_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12">Gambar Produk</label>
                                                <div class="col-md-12">
                                                    <input type="file" name="product_image"
                                                        class="form-control form-control-line">
                                                    @if ($products->product_image) <small> Gambar Kamu Saat Ini:
                                                    <td><img src="{{ asset('storage/' . $products->product_image) }}"
                                                        width="50" height="50"
                                                        style="object-fit:cover; border-radius:5px;"></td>
                                                    </small>
                                                    @endif
                                                    @error('product_image')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12">Harga <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" name="price" id="price"
                                                        value="Rp {{ number_format($products->price, 0, ',', '.') }}"
                                                        class="form-control form-control-line">
                                                    @error('price')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12">Stok <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="number" name="stock" value="{{ old('stock', $products->stock) }}"
                                                        disabled class="form-control form-control-line">
                                                    @error('stock')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-end">
                                        <div class="col text-end">
                                            <button type="submit" class="btn btn-primary w-25">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const inputPrice = document.getElementById('price');
            inputPrice.addEventListener('input', function(e) {
                let angka = e.target.value.replace(/[^0-9]/g, '');
                e.target.value = formatRupiah(angka);
            });

            function formatRupiah(angka) {
                let number_string = angka.toString(),
                    sisa = number_string.length % 3,
                    rupiah = number_string.substr(0, sisa),
                    ribuan = number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return 'Rp. ' + rupiah;
            }
        </script>

    </body>

    </html>

</x-layout>
