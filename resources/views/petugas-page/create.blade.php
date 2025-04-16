<x-layout>
    <div class="pagetitle">
        <h1>Halaman Pembayaran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('petugas.create') }}">Tambah Penjualan</a></li>
                <li class="breadcrumb-item active">Pembayaran</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-body p-4">
                <div class="row">
                    {{-- Kolom Kiri: Produk --}}
                    <div class="col-md-6">
                        <h4 class="fw-bold mb-3">Produk yang Dipilih</h4>
                        <div id="selected-products"></div>
                        <h5 class="fw-bold mt-3">Total Harga <span id="total-price" class="float-end">Rp. 0</span></h5>
                    </div>

                    {{-- Kolom Kanan: Form --}}
                    <div class="col-md-6">
                        <form action="{{route('petugas.store')}}" method="POST">
                            @csrf

                            {{-- Status Customer --}}
                            <div class="mb-3">
                                <label for="customer-status" class="form-label">Status Customer</label>
                                <select id="customer-status" name="customer_status" class="form-select">
                                    <option value="Non-Member" {{ old('customer_status') == 'Non-Member' ? 'selected' : '' }}>Non-Member</option>
                                    <option value="Member" {{ old('customer_status') == 'Member' ? 'selected' : '' }}>Member</option>
                                </select>
                            </div>

                            {{-- Input nomor telepon (hanya muncul jika Member) --}}
                            <div id="phone-input-container" class="mb-3" style="display: none;">
                                <label class="form-label">No Telepon <span class="text-danger">(Daftar/gunakan member)</span></label>
                                <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Masukkan nomor telepon">
                            </div>

                            {{-- Jumlah Dibayar --}}
                            <div class="mb-3">
                                <label class="form-label">Jumlah Dibayar</label>
                                <input type="text" class="form-control" id="amount-paid" name="amount_paid" placeholder="Masukkan jumlah bayar">
                                <small id="error-message" class="text-danger d-none">Jumlah bayar kurang.</small>
                            </div>

                            {{-- Hidden Total Harga --}}
                            <input type="hidden" name="total_price" id="input-total-price">

                            {{-- Produk Hidden --}}
                            <div id="product-inputs"></div>

                            {{-- Tombol Submit --}}
                            <button class="btn btn-primary w-100 mt-3 mb-3" id="btn-submit" disabled>Selesaikan Pembayaran</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Script --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let cart = JSON.parse(localStorage.getItem("cart")) || {};
            let totalPrice = 0;

            // Referensi elemen-elemen yang digunakan
            const selectedProducts = document.getElementById("selected-products");
            const inputTotalPrice = document.getElementById("input-total-price");
            const totalPriceElement = document.getElementById("total-price");
            const amountPaidInput = document.getElementById("amount-paid");
            const btnSubmit = document.getElementById("btn-submit");
            const productInputs = document.getElementById("product-inputs");
            const errorMessage = document.getElementById("error-message");
            const customerStatusDropdown = document.getElementById("customer-status");
            const phoneInputContainer = document.getElementById("phone-input-container");

            // Menampilkan produk yang ada di keranjang
            Object.values(cart).forEach(product => {
                const subtotal = product.jumlah * product.price;
                totalPrice += subtotal;

                selectedProducts.innerHTML += `
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <strong>${product.name}</strong>
                            <div><small>Rp. ${product.price.toLocaleString("id-ID")} x ${product.jumlah}</small></div>
                        </div>
                        <div class="fw-bold">Rp. ${subtotal.toLocaleString("id-ID")}</div>
                    </div>
                `;

                productInputs.innerHTML += `
                    <input type="hidden" name="products[${product.id}][id]" value="${product.id}">
                    <input type="hidden" name="products[${product.id}][jumlah]" value="${product.jumlah}">
                `;
            });

            // Menampilkan total harga
            totalPriceElement.textContent = "Rp. " + totalPrice.toLocaleString("id-ID");
            inputTotalPrice.value = totalPrice;

            // Fungsi untuk membersihkan format rupiah
            function cleanRupiah(str) {
                return parseInt(str.replace(/[^\d]/g, "")) || 0;
            }

            // Fungsi untuk update validasi pembayaran
            function updateValidation() {
                const bayar = cleanRupiah(amountPaidInput.value);
                if (bayar < totalPrice) {
                    errorMessage.classList.remove("d-none");
                    btnSubmit.setAttribute("disabled", true);
                } else {
                    errorMessage.classList.add("d-none");
                    btnSubmit.removeAttribute("disabled");
                }
            }

            // Event listener untuk input pembayaran
            amountPaidInput.addEventListener("input", function () {
                this.value = this.value ? "Rp. " + cleanRupiah(this.value).toLocaleString("id-ID") : "";
                updateValidation();
            });

            // Validasi saat form disubmit
            document.querySelector("form").addEventListener("submit", function (e) {
                const bayar = cleanRupiah(amountPaidInput.value);
                if (bayar < totalPrice) {
                    e.preventDefault();
                    return;
                }

                amountPaidInput.value = cleanRupiah(amountPaidInput.value);
                localStorage.removeItem("cart");
            });

            // Menangani perubahan status customer
            function toggleCustomerInputVisibility() {
                if (customerStatusDropdown.value === "Member") {
                    phoneInputContainer.style.display = "block";
                } else {
                    phoneInputContainer.style.display = "none";
                }
            }

            // Inisialisasi status customer saat halaman pertama kali dimuat
            toggleCustomerInputVisibility();

            // Event listener untuk dropdown status customer
            customerStatusDropdown.addEventListener("change", toggleCustomerInputVisibility);
        });
    </script>
</x-layout>
