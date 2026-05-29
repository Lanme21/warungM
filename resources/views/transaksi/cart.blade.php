<x-layouts>
    @push('styles')
        <style>
            /* CSS khusus untuk print */
            @media print {

                /* Sembunyikan semua elemen di layar secara default */
                body * {
                    visibility: hidden;
                }

                /* Tampilkan hanya kontainer struk dan seluruh isinya */
                #struk-print-area,
                #struk-print-area * {
                    visibility: visible;
                }

                /* Posisikan struk dengan paksa di pojok kiri atas kertas */
                #struk-print-area {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 58mm;
                    /* Sesuaikan dengan lebar kertas thermal */
                    margin: 0;
                    padding: 0;
                    font-family: 'Courier New', Courier, monospace;
                    font-size: 12px;
                    color: black;
                }

                @page {
                    size: auto;
                    margin: 0mm;
                }
            }
        </style>
    @endpush
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.css">

    <div class="relative w-full mx-auto mt-20">
        <form id="mycart">
            @csrf
            <div
                class="relative flex flex-col flex-auto min-w-0 p-4 mx-6 overflow-hidden break-words bg-white border-0 dark:bg-slate-850 dark:shadow-dark-xl shadow-3xl rounded-2xl bg-clip-border">
                <div class="flex flex-wrap -mx-3">
                    <div class="flex-none w-auto max-w-full px-3 my-auto sm:w-4/12 md:w-4/12 lg:w-4/12">
                        <div class="h-full">
                            <p class="mb-0 text-sm font-semibold leading-normal dark:text-white dark:opacity-60">Silahkan
                                scan qr disini</p>
                            <div class="flex items-center gap-2 mt-1">
                                <input type="text" id="cart_kode" name="cart_kode" autofocus
                                    placeholder="Scan QR Code"
                                    class="block w-full px-3 py-2 text-sm font-normal text-gray-700 transition-all bg-white border border-gray-300 border-solid rounded-lg outline-none focus:border-blue-500 focus:outline-none dark:bg-slate-850 dark:text-white" />
                                <button type="button" id="btn-scan"
                                    class="inline-block px-4 py-2 text-xs font-bold text-center text-white uppercase transition-all bg-blue-500 rounded-lg shadow-md cursor-pointer hover:-translate-y-px active:opacity-85 hover:shadow-md">
                                    Kamera
                                </button>
                            </div>
                            <div id="reader"
                                class="hidden w-full mt-3 overflow-hidden border border-gray-300 rounded-lg"></div>
                        </div>
                    </div>

                    <div class="w-full max-w-full px-3 mx-auto mt-4 sm:my-auto sm:mr-0 sm:w-8/12 md:w-8/12 lg:w-8/12">
                        <ul class="relative flex flex-wrap p-1 list-none bg-gray-50 rounded-xl">
                            <li class="z-30 flex-auto text-center">
                                <p class="mb-0 text-sm font-semibold leading-normal dark:text-white dark:opacity-60">
                                    Nama Item</p>
                                <input type="text" id="cart_barang" name="cart_barang" readonly
                                    class="w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg dark:bg-slate-850 dark:text-white" />
                            </li>
                            <li class="z-30 flex-auto text-center">
                                <p class="mb-0 text-sm font-semibold leading-normal dark:text-white dark:opacity-60">
                                    Satuan</p>
                                <input type="text" id="cart_satuan" name="cart_satuan" readonly
                                    class="w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg dark:bg-slate-850 dark:text-white" />
                            </li>
                            <li class="z-30 flex-auto text-center">
                                <p class="mb-0 text-sm font-semibold leading-normal dark:text-white dark:opacity-60">
                                    Jumlah</p>
                                <input type="number" step="1" min="1" id="cart_jumlah" name="cart_jumlah"
                                    class="w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg dark:bg-slate-850 dark:text-white focus:border-blue-500 focus:outline-none" />
                            </li>
                            <li class="z-30 flex-auto text-center">
                                <p class="mb-0 text-sm font-semibold leading-normal dark:text-white dark:opacity-60">
                                    Harga</p>
                                <input type="number" id="cart_harga" name="cart_harga" readonly
                                    class="w-full px-3 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg dark:bg-slate-850 dark:text-white" />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="w-full p-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 shrink-0">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl">

                    <div class="p-6 pb-0 border-b-0 border-solid border-black/12.5 rounded-t-2xl">
                        <div class="flex items-center justify-between mb-4">
                            <p class="mb-0 font-bold dark:text-white/80">Daftar Belanjaan</p>
                            <button type="button" id="btn-masukan"
                                class="px-8 py-2 text-sm font-bold text-white transition-all bg-blue-500 rounded-lg shadow-md hover:shadow-xs active:opacity-85">Masukan</button>
                        </div>
                    </div>

                    <div class="flex-auto px-6 overflow-x-auto">
                        <table id="example"
                            class="items-center w-full mb-0 align-top border-collapse text-slate-500 display">
                            <thead class="align-bottom">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-sm font-bold text-left uppercase whitespace-nowrap text-slate-400">
                                        Nama Item</th>
                                    <th
                                        class="px-6 py-3 text-sm font-bold text-left uppercase whitespace-nowrap text-slate-400">
                                        Jumlah</th>
                                    <th
                                        class="px-6 py-3 text-sm font-bold text-center uppercase whitespace-nowrap text-slate-400">
                                        Satuan</th>
                                    <th
                                        class="px-6 py-3 text-sm font-bold text-center uppercase whitespace-nowrap text-slate-400">
                                        Harga</th>
                                    <th
                                        class="px-6 py-3 text-sm font-bold text-center uppercase whitespace-nowrap text-slate-400">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="fetchcartitem"></tbody>
                        </table>
                    </div>

                    <form id="checkoutForm">
                        @csrf
                        <div class="flex-auto px-6 py-4">
                            <ul class="flex flex-col mb-0 rounded-lg">
                                <li class="flex items-center justify-between px-4 py-2 rounded-xl">
                                    <h6 class="text-sm font-semibold dark:text-white text-slate-700">Total Bayar</h6>
                                    <input type="text" id="total_bayar" readonly
                                        class="text-center px-3 py-2 text-sm border border-gray-300 rounded-lg dark:bg-slate-850 dark:text-white focus:outline-none" />
                                </li>
                                <li class="flex items-center justify-between px-4 py-2 rounded-xl">
                                    <h6 class="text-sm font-semibold dark:text-white text-slate-700">Nominal Bayar</h6>
                                    <input type="text" id="nominal_bayar" placeholder="Nominal Bayar"
                                        class="text-center px-3 py-2 text-sm border border-gray-300 rounded-lg focus:border-blue-500 dark:bg-slate-850 dark:text-white focus:outline-none" />
                                </li>
                                <li class="flex items-center justify-between px-4 py-2 rounded-xl">
                                    <h6 class="text-sm font-semibold dark:text-white text-slate-700">Kembalian</h6>
                                    <input type="text" id="total_kembalian" readonly placeholder="Kembalian"
                                        class="text-center px-3 py-2 text-sm border border-gray-300 rounded-lg dark:bg-slate-850 dark:text-white focus:outline-none" />
                                </li>
                            </ul>
                        </div>
                        <div class="p-6 border-t border-solid border-black/12.5 rounded-b-2xl">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ url('/clearcart') }}" style="background-color: #b81414;"
                                    class="px-8 py-2 text-sm font-bold text-white transition-all  rounded-lg shadow-md ">Kosongkan</a>
                                <button type="submit"
                                    class="px-8 py-2 text-sm font-bold text-white transition-all bg-blue-500 rounded-lg shadow-md hover:bg-blue-600">Check
                                    out</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

        <script>
            /** ==========================================
             * UTILITY FUNCTIONS
             * ========================================== */
            const formatRupiah = (angka) => String(Math.round(angka)).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            const getAngkaMurni = (formatted) => formatted.replace(/[^0-9]/g, '') || 0;

            const inputRupiah = (angka) => {
                let number_string = angka.replace(/[^,\d]/g, '').toString();
                let split = number_string.split(',');
                let sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return rupiah ? 'Rp ' + rupiah : '';
            };

            /** ==========================================
             * CORE APPLICATION LOGIC
             * ========================================== */
            $(document).ready(function() {
                // 1. Inisialisasi DataTables
                new DataTable("#example", {
                    info: false,
                    search: false,
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '50vh'
                });

                // 2. Fetch Keranjang Saat Load
                fetchData();

                // 3. Setup CSRF Token AJAX Secara Global
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // ================= SCANNER QR =================
                let html5QrcodeScanner = null;
                $('#btn-scan').on('click', function() {
                    $('#reader').removeClass('hidden');
                    if (!html5QrcodeScanner) {
                        html5QrcodeScanner = new Html5QrcodeScanner("reader", {
                            fps: 10,
                            qrbox: {
                                width: 250,
                                height: 250
                            },
                            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
                        }, false);

                        html5QrcodeScanner.render((decodedText) => {
                            $('#cart_kode').val(decodedText).trigger('change');
                            html5QrcodeScanner.clear().then(() => {
                                html5QrcodeScanner = null;
                                $('#reader').addClass('hidden');
                            });
                        }, (err) => {
                            /* Abaikan error scan frame */
                        });
                    }
                });

                // ================= PENCARIAN BARANG =================
                $('#cart_kode').on('keypress', function(e) {
                    if (e.which == 13) {
                        e.preventDefault();
                        cariBarang($(this).val());
                    }
                }).on('change', function() {
                    cariBarang($(this).val()); // Aktif saat scanner mengisi nilai
                });

                function cariBarang(kodeBarang) {
                    if (!kodeBarang) return;
                    $.get("/fetch-barang", {
                            kode_barang: kodeBarang
                        })
                        .done(function(response) {
                            $("#cart_barang").val(response.data.barangs.nama);
                            $("#cart_satuan").val(response.data.barangs.kategori + " / " + response.data.barangs
                                .satuan);
                            $("#cart_jumlah").val(1).attr('max', response.data.stok);
                            $("#cart_harga").val(formatRupiah(response.data.harga_jual));
                            simpanKeKeranjang();
                        })
                        .fail(function(xhr) {
                            console.error(xhr);
                            $('#cart_kode').val('').focus();
                        });
                }

                // ================= UPDATE HARGA =================
                $("#cart_jumlah").on('change', function() {
                    let jumlah = $(this).val();
                    let kodeBarang = $("#cart_kode").val();
                    if (kodeBarang) {
                        $.get("/fetch-barang", {
                                kode_barang: kodeBarang
                            })
                            .done(function(response) {
                                $("#cart_harga").val(formatRupiah(response.data.harga_jual * jumlah));
                            });
                    }
                });

                // ================= TAMBAH KERANJANG =================
                function simpanKeKeranjang() {
                    if ($("#cart_kode").val() === "") return alert("Kode barang tidak boleh kosong");

                    let formData = {
                        cart_kode: $("#cart_kode").val(),
                        cart_barang: $("#cart_barang").val(),
                        cart_satuan: $("#cart_satuan").val(),
                        cart_jumlah: $("#cart_jumlah").val(),
                        cart_harga: getAngkaMurni($("#cart_harga").val()),
                    };

                    $.post("{{ url('mycart') }}", formData)
                        .done(function() {
                            $("#mycart")[0].reset();
                            fetchData();
                            $("#cart_jumlah").blur();
                            $("#cart_kode").focus();
                        })
                        .fail(function(xhr) {
                            alert("Terjadi kesalahan saat menambahkan item ke keranjang.");
                        });
                }

                $('#btn-masukan').on('click', simpanKeKeranjang);

                // ================= FETCH DATA TABEL & STRUK =================
                function fetchData() {
                    $.get("{{ url('/fetchcartitems') }}")
                        .done(function(response) {
                            $('#fetchcartitem').empty();
                            $('#print-cart-items').empty(); // Kosongkan area struk sebelum diisi ulang

                            if (response.success && response.data.length > 0) {
                                $.each(response.data, function(index, cart) {
                                    // Masukkan ke tabel utama
                                    $('#fetchcartitem').append(`
                        <tr>
                            <td class="p-2 text-sm text-center align-middle border-b"><h6 class="mb-0 dark:text-white">${cart.cart_kode}</h6></td>
                            <td class="p-2 text-sm text-center align-middle border-b">${cart.cart_barang}</td>
                            <td class="p-2 text-sm text-center align-middle border-b"><input type="number" value="${cart.cart_jumlah}" class="w-16 text-center border rounded"/></td>
                            <td class="p-2 text-sm text-center align-middle border-b">${cart.cart_satuan}</td>
                            <td class="p-2 text-sm text-center align-middle border-b">${formatRupiah(cart.cart_harga)}</td>
                            <td class="p-2 text-sm text-center align-middle border-b"></td>
                        </tr>
                    `);

                                    // Masukkan ke area cetak struk
                                    $('#print-cart-items').append(`
                        <tr>
                            <td style="font-size: 12px; text-align: left; padding: 2px 0;">${cart.cart_barang}</td>
                            <td style="font-size: 12px; text-align: center; padding: 2px 0;">x${cart.cart_jumlah}</td>
                            <td style="font-size: 12px; text-align: right; padding: 2px 0;">${formatRupiah(cart.cart_harga)}</td>
                        </tr>
                    `);
                                });
                                $('#total_bayar').val(formatRupiah(response.total));
                                $('#print-total-harga').text(formatRupiah(response.total)); // Update total di struk
                            } else {
                                $('#fetchcartitem').append(
                                    '<tr><td colspan="6" class="p-4 text-center">Data kosong</td></tr>');
                                $('#print-cart-items').append(
                                    '<tr><td colspan="3" style="text-align: center;">Kosong</td></tr>');
                                $('#total_bayar').val(0);
                                $('#print-total-harga').text('0');
                            }
                            $('#nominal_bayar').val('').trigger('keyup'); // Reset input bayar
                        });
                }
                // ================= HITUNG KEMBALIAN =================
                $('#nominal_bayar').on('keyup', function() {
                    $(this).val(inputRupiah($(this).val())); // Format input langsung

                    let bayar_murni = parseInt(getAngkaMurni($(this).val())) || 0;
                    let total_murni = parseInt(getAngkaMurni($("#total_bayar").val())) || 0;

                    let kembalian = bayar_murni - total_murni;
                    $("#total_kembalian").val(kembalian > 0 ? formatRupiah(kembalian) : 0);
                });

                // ================= CHECKOUT =================
                // ================= CHECKOUT =================
                $("#checkoutForm").on('submit', function(e) {
                    e.preventDefault();

                    let bayar = parseInt(getAngkaMurni($("#nominal_bayar").val())) || 0;
                    let total = parseInt(getAngkaMurni($("#total_bayar").val())) || 0;
                    let kembalian = bayar - total;

                    if (kembalian >= 0 && bayar > 0) {
                        // 1. Tampilkan area struk agar bisa masuk ke DOM untuk dicetak
                        $('#struk-print-area').removeClass('hidden');

                        // 2. Beri jeda sedikit agar browser merender struk, lalu trigger Print
                        setTimeout(function() {
                            window.print();
                        }, 300);

                        // 3. Tangkap event ketika dialog print ditutup (baik diprint maupun di-cancel)
                        window.onafterprint = function() {
                            // Sembunyikan struk kembali
                            $('#struk-print-area').addClass('hidden');

                            // Hapus event listener agar tidak terpicu berkali-kali di masa depan
                            window.onafterprint = null;

                            // 4. Setelah print selesai, kirim data ke database via AJAX POST
                            $.post("{{ url('/checkoutcart') }}", {
                                    susuk: kembalian
                                })
                                .done(function(response) {
                                    // Tampilkan pesan sukses dengan SweetAlert setelah berhasil masuk database
                                    Swal.fire({
                                        title: "Transaksi Berhasil!",
                                        text: "Kembalian: Rp " + formatRupiah(kembalian),
                                        icon: "success",
                                        confirmButtonText: "Selesai",
                                        allowOutsideClick: false
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                })
                                .fail(function() {
                                    Swal.fire({
                                        title: "Gagal!",
                                        text: "Terjadi kesalahan saat menyimpan transaksi ke database.",
                                        icon: "error"
                                    });
                                });
                        };
                    } else {
                        Swal.fire({
                            title: "Pembayaran Kurang!",
                            text: "Nominal yang dimasukkan tidak mencukupi total belanja.",
                            icon: "warning"
                        });
                    }
                });

            });
        </script>
    @endpush




    <div id="struk-print-area" class="hidden">
        <div class="struk-container">
            <div class="text-center">
                <h3 style="margin: 0; font-size: 16px;">NAMA TOKO ANDA</h3>
                <p style="margin: 0;">Jl. Alamat Toko No. 123</p>
                <p style="margin: 0;">Telp: 08123456789</p>
                <p>--------------------------------</p>
            </div>

            <table style="width: 100%; border-collapse: collapse;">
                <tbody id="print-cart-items"></tbody>
            </table>

            <div class="text-center" style="margin-top: 10px;">
                <p>--------------------------------</p>
                <p style="margin: 0; font-size: 14px;"><strong>TOTAL: <span id="print-total-harga">Rp
                            0</span></strong></p>
                <p>--------------------------------</p>
                <p style="margin-top: 10px;">Terima Kasih</p>
                <p>Barang yang sudah dibeli<br>tidak dapat ditukar</p>
            </div>
        </div>
    </div>
</x-layouts>
