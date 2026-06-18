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
                                        class="px-6 py-3 text-sm font-bold text-center uppercase whitespace-nowrap text-slate-400">
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
                                    class="px-8 py-2 text-sm font-bold text-white transition-all rounded-lg shadow-md">Kosongkan</a>
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
                let table = new DataTable("#example", {
                    info: false,
                    search: false,
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '50vh'
                });

                // Setup CSRF Token AJAX Secara Global (Pastikan Anda memiliki meta tag csrf-token di layout utama)
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // 2. Fetch Keranjang Saat Load
                fetchData();

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
                    cariBarang($(this).val());
                });

                function cariBarang(kodeBarang) {
                    if (!kodeBarang) return;
                    $.get("/cek-harga", {
                            kode_barang: kodeBarang
                        })
                        .done(function(response) {
                            console.log(response); // Cek struktur objek di console log browser

                            // VALIDASI: Pastikan response sukses dan objek 'barang' dari relasi itu ada
                            if (response.success && response.data) {

                                // 1. Ambil nama dari relasi barang (response.data.nama)
                                $("#cart_barang").val(response.data.nama);

                                // 2. Ambil kategori dan satuan dari relasi barang
                                $("#cart_satuan").val(response.data.kategori + " / " + response.data
                                    .satuan);

                                // 3. Stok dan Harga Jual diambil dari tabel etalase langsung
                                $("#cart_jumlah").val(1).attr('max', response.data.stok);
                                $("#cart_harga").val(formatRupiah(response.data.etalase.harga_jual));

                                // Jalankan fungsi simpan
                                simpanKeKeranjang();

                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Data master barang tidak ditemukan untuk kode ini!'
                                });
                                $('#cart_kode').val('').focus();
                            }
                        })
                        .fail(function(xhr) {
                            console.error(xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Barcode tidak terdaftar atau terjadi kesalahan server.'
                            });
                            $('#cart_kode').val('').focus();
                        });
                }

                // ================= UPDATE HARGA INPUT FORM =================
                $("#cart_jumlah").on('change keyup', function() {
                    let jumlah = $(this).val() || 1;
                    let kodeBarang = $("#cart_kode").val();
                    if (kodeBarang) {
                        $.get("/fetch-barang", {
                                kode_barang: kodeBarang
                            })
                            .done(function(response) {
                                $("#cart_harga").val(formatRupiah(response.data.etalase.harga_jual *
                                    jumlah));
                            });
                    }
                });

                // ================= TAMBAH KERANJANG =================
                function simpanKeKeranjang() {
                    if ($("#cart_kode").val() === "") return alert("Kode barang tidak boleh kosong");

                    let formData = {
                        _token: $('input[name="_token"]').val(),
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
                            table.clear(); // Bersihkan instansi DataTable
                            $('#print-cart-items').empty();

                            if (response.success && response.data.length > 0) {
                                $.each(response.data, function(index, cart) {
                                    // Masukkan data terstruktur ke DataTable API (5 kolom pas)
                                    table.row.add([
                                        `<div class="text-left">
                                            <h6 class="mb-0 text-sm font-semibold dark:text-white">${cart.cart_barang}</h6>
                                            <small class="text-slate-400 font-normal">${cart.cart_kode}</small>
                                        </div>`,
                                        `<div class="text-center">
                                            <input type="number" min="1" value="${cart.cart_jumlah}" data-kode="${cart.cart_kode}" 
                                                class="w-16 text-center border rounded update-qty-input dark:bg-slate-800 dark:text-white" />
                                        </div>`,
                                        `<div class="text-center text-sm">${cart.cart_satuan}</div>`,
                                        `<div class="text-center text-sm font-semibold">${formatRupiah(cart.cart_harga)}</div>`,
                                        `<div class="text-center">
                                            <button type="button" data-kode="${cart.cart_kode}" 
                                                class="px-3 py-1 text-xs font-bold text-white bg-red-600 rounded-lg btn-hapus-item hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </div>`
                                    ]);

                                    // Masukkan ke area cetak struk
                                    $('#print-cart-items').append(`
                                        <tr>
                                            <td style="font-size: 11px; text-align: left; padding: 2px 0;">${cart.cart_barang}</td>
                                            <td style="font-size: 11px; text-align: center; padding: 2px 0;">x${cart.cart_jumlah}</td>
                                            <td style="font-size: 11px; text-align: right; padding: 2px 0;">${formatRupiah(cart.cart_harga)}</td>
                                        </tr>
                                    `);
                                });

                                table.draw(false); // Render ulang tabel
                                $('#total_bayar').val(formatRupiah(response.total));
                                $('#print-total-harga').text('Rp ' + formatRupiah(response.total));
                            } else {
                                table.draw(false);
                                $('#print-cart-items').append(
                                    '<tr><td colspan="3" style="text-align: center; padding: 5px 0;">Kosong</td></tr>'
                                );
                                $('#total_bayar').val(0);
                                $('#print-total-harga').text('Rp 0');
                            }
                            $('#nominal_bayar').val('').trigger('keyup');
                        });
                }

                // ================= EVENT LISTENER DI DALAM TABEL (DYNAMIC ELEMENTS) =================

                // 1. Aksi Ubah Qty Langsung Dari Tabel
                $(document).on('change', '.update-qty-input', function() {
                    let kode = $(this).data('kode');
                    let qtybaru = $(this).val();
                    if (qtybaru < 1) return fetchData();

                    $.post("{{ url('/updatecartqty') }}", {
                            cart_kode: kode,
                            cart_jumlah: qtybaru
                        })
                        .done(function() {
                            fetchData();
                        })
                        .fail(function() {
                            alert("Gagal memperbarui jumlah item");
                        });
                });

                // 2. Aksi Hapus Satuan Barang
                $(document).on('click', '.btn-hapus-item', function() {
                    let kode = $(this).data('kode');
                    Swal.fire({
                        title: "Hapus Item?",
                        text: "Item ini akan dikeluarkan dari daftar belanja.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Hapus!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.post("{{ url('/deletecartitem') }}", {
                                    cart_kode: kode
                                })
                                .done(function() {
                                    fetchData();
                                });
                        }
                    });
                });

                // ================= HITUNG KEMBALIAN =================
                $('#nominal_bayar').on('keyup', function() {
                    $(this).val(inputRupiah($(this).val()));

                    let bayar_murni = parseInt(getAngkaMurni($(this).val())) || 0;
                    let total_murni = parseInt(getAngkaMurni($("#total_bayar").val())) || 0;

                    let kembalian = bayar_murni - total_murni;
                    $("#total_kembalian").val(kembalian >= 0 ? formatRupiah(kembalian) : 0);

                    // Update teks struk secara real-time
                    $('#print-bayar').text($(this).val() || 'Rp 0');
                    $('#print-kembalian').text(kembalian >= 0 ? 'Rp ' + formatRupiah(kembalian) : 'Rp 0');
                });

                // ================= CHECKOUT =================
                $("#checkoutForm").on('submit', function(e) {
                    e.preventDefault();

                    let bayar = parseInt(getAngkaMurni($("#nominal_bayar").val())) || 0;
                    let total = parseInt(getAngkaMurni($("#total_bayar").val())) || 0;
                    let kembalian = bayar - total;

                    if (kembalian >= 0 && bayar > 0) {
                        // 1. Tampilkan area struk ke DOM layar sebelum dicetak
                        $('#struk-print-area').removeClass('hidden');

                        // 2. Beri jeda minim agar browser siap merender, lalu trigger Print
                        setTimeout(function() {
                            window.print();
                        }, 300);

                        // 3. Setelah dialog cetak selesai dijalankan kasir
                        window.onafterprint = function() {
                            $('#struk-print-area').addClass('hidden');
                            window.onafterprint = null; // Unbind handler

                            // 4. Push data transaksi final ke DB via POST
                            $.post("{{ url('/checkoutcart') }}", {
                                    susuk: kembalian,
                                    nominal_bayar: bayar
                                })
                                .done(function(response) {
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
        <div class="struk-container" style="padding: 5px;">
            <div class="text-center" style="text-align: center;">
                <h3 style="margin: 0; font-size: 14px; font-weight: bold;">NAMA TOKO ANDA</h3>
                <p style="margin: 0; font-size: 10px;">Jl. Alamat Toko No. 123</p>
                <p style="margin: 0; font-size: 10px;">Telp: 08123456789</p>
                <p style="margin: 2px 0;">--------------------------------</p>
            </div>

            <table style="width: 100%; border-collapse: collapse;">
                <tbody id="print-cart-items"></tbody>
            </table>

            <div style="margin-top: 5px;">
                <p style="margin: 2px 0;">--------------------------------</p>
                <table style="width: 100%; font-size: 11px;">
                    <tr>
                        <td style="text-align: left; font-weight: bold;">TOTAL:</td>
                        <td id="print-total-harga" style="text-align: right; font-weight: bold;">Rp 0</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">BAYAR:</td>
                        <td id="print-bayar" style="text-align: right;">Rp 0</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">KEMBALI:</td>
                        <td id="print-kembalian" style="text-align: right;">Rp 0</td>
                    </tr>
                </table>
                <p style="margin: 2px 0;">--------------------------------</p>
                <div class="text-center" style="text-align: center; font-size: 10px; margin-top: 5px;">
                    <p style="margin: 0;">Terima Kasih</p>
                    <p style="margin: 0;">Barang yang sudah dibeli<br>tidak dapat ditukar</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts>
