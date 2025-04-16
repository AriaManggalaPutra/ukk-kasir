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
                                <form class="form-horizontal form-material mx-2" method="POST"
                                    action="{{ route('admin-create-store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12">Nama Produk <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="text" name="product_name"
                                                        class="form-control form-control-line ">
                                                    @error('product_name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12">Gambar Produk <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="file" name="product_image"
                                                        class="form-control form-control-line ">
                                                    @error('product_image')
                                                        <small class="text-danger">{{ $message }}</small>
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
                                                    {{-- Tampilkan input harga untuk user --}}
                                                    <input type="text" id="price_display"
                                                        class="form-control form-control-line">
                                                    {{-- Kirimkan ke server input tersembunyi yang hanya berisi angka --}}
                                                    <input type="hidden" name="price" id="price">
                                                    @error('price')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12">Stok <span class="text-danger">*</span></label>
                                                <div class="col-md-12">
                                                    <input type="number" name="stock"
                                                        class="form-control form-control-line ">
                                                    @error('stock')
                                                        <small class="text-danger">{{ $message }}</small>
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
            $(document).ready(function() {
                // Menambahkan validasi harga dan stok saat form disubmit
                $('form').submit(function(event) {
                    var price = $('#price').val();
                    var stock = $('input[name="stock"]').val();

                    // Menghapus tanda pemisah ribuan untuk validasi angka
                    var priceNumber = parseInt(price.replace(/[^0-9]/g, ''));
                    var stockNumber = parseInt(stock.replace(/[^0-9]/g, ''));

                    // Cek apakah harga lebih dari 10 juta
                    if (priceNumber > 10000000) {
                        notif('error', 'Harga tidak boleh lebih dari 10 juta');
                        event.preventDefault();  // Mencegah form untuk disubmit
                        return false;
                    }

                    // Cek apakah stok lebih dari 10 juta
                    if (stockNumber > 10000000) {
                        notif('error', 'Stok tidak boleh lebih dari 10 juta');
                        event.preventDefault();  // Mencegah form untuk disubmit
                        return false;
                    }
                });

                // Format harga input
                $('#price').keyup(function(e) {
                    e.target.value = formatRupiah(this.value, 'Rp. ');
                });

                const formatRupiah = (angka, prefix) => {
                    var number_string = angka.replace(/[^,\d]/g, '').toString(),
                        split = number_string.split(','),
                        sisa = split[0].length % 3,
                        rupiah = split[0].substr(0, sisa),
                        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }

                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                }

                $('#price_display').on('keyup', function(e) {
                    let angkaBersih = this.value.replace(/[^0-9]/g, '');
                    $('#price').val(angkaBersih); // untuk dikirim ke backend
                    this.value = formatRupiah(this.value, 'Rp. ');
                });
            });

            function notif(type, msg) {
                Swal.fire({
                    icon: type,
                    text: msg
                });
            }
        </script>
        <script src="http://45.64.100.26:88/ukk-kasir/public/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="http://45.64.100.26:88/ukk-kasir/public/dist/js/app-style-switcher.js"></script>
        <script src="http://45.64.100.26:88/ukk-kasir/public/plugins/swal2.js"></script>
        <script src="http://45.64.100.26:88/ukk-kasir/public/dist/js/waves.js"></script>
        <script src="http://45.64.100.26:88/ukk-kasir/public/dist/js/sidebarmenu.js"></script>
        <script src="http://45.64.100.26:88/ukk-kasir/public/dist/js/custom.js"></script>
        <script src="http://45.64.100.26:88/ukk-kasir/public/assets/libs/chartist/dist/chartist.min.js"></script>
        <script
            src="http://45.64.100.26:88/ukk-kasir/public/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js">
        </script>
        <script src="http://45.64.100.26:88/ukk-kasir/public/dist/js/pages/dashboards/dashboard1.js"></script>
    </body>

    </html>
</x-layout>
