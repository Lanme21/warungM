<x-home>
    <section>
        <div class="relative flex items-center min-h-screen p-0 overflow-hidden bg-center bg-cover">
            <div class="container z-1">
                <div class="flex flex-wrap -mx-3">

                    <div
                        class="flex flex-col w-full max-w-full px-3 mx-auto lg:mx-0 shrink-0 md:flex-0 md:w-7/12 lg:w-5/12 xl:w-4/12">
                        <div
                            class="relative flex flex-col min-w-0 break-words bg-transparent border-0 shadow-none lg:py-4 dark:bg-gray-950 rounded-2xl bg-clip-border">
                            <div class="p-6 pb-0 mb-0">
                                <h1 id="nama_barang" class="font-bold text-[3rem]">Nama Barang</h1>
                                <p id="kategori_satuan" class="mb-0 text-[2.5rem]">Kategori/Satuan</p>
                            </div>
                            <div class="flex-auto p-6">
                                <form role="form">
                                    <div class="mb-4 flex items-center gap-3">
                                        <button type="button" id="btn-scan"
                                            class="inline-block px-6 py-3 text-sm font-bold text-center text-white uppercase transition-all bg-blue-500 rounded-lg shadow-md cursor-pointer hover:-translate-y-px active:opacity-85 hover:shadow-md whitespace-nowrap">
                                            Kamera
                                        </button>

                                        <input type="text" id="harga_barang" placeholder="Harga Barang"
                                            value="" readonly
                                            class="text-[2.5rem] focus:shadow-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 leading-normal ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding p-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div id="reader" class="w-full mb-2" style="display: none;"></div>
                                </form>
                            </div>
                            <div
                                class="border-black/12.5 rounded-b-2xl border-t-0 border-solid p-6 text-center pt-0 px-1 sm:px-6">
                                <p class="mx-auto mb-6 leading-normal text-sm">Untuk melihat daftar barang silahkan klik
                                    <a href="#"
                                        class="font-semibold text-transparent bg-clip-text bg-gradient-to-tl from-blue-500 to-violet-500">disini</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="absolute top-0 right-0 flex-col justify-center hidden w-6/12 h-full max-w-full px-3 pr-0 my-auto text-center flex-0 lg:flex">
                        <div class="relative flex flex-col justify-center h-full bg-cover px-24 m-4 bg-center overflow-hidden rounded-xl"
                            style="background-image: url('{{ asset('assets/img/background-baru.png') }}');">
                            <span
                                class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-zinc-800 to-zinc-700 opacity-60"></span>
                            <div
                                class="relative flex flex-col min-w-0 break-words bg-transparent border-0 shadow-none lg:py-4 dark:bg-gray-950 rounded-2xl bg-clip-border">
                                <div class="p-6 pb-0 mb-0">
                                    <h4 class="font-bold text-white">Cek Harga Barang</h4>
                                    <p class="mb-0 text-white">Silahkan scan barcode yang terdapat di product</p>
                                </div>
                                <div class="flex-auto p-6">
                                    <form>
                                        <div class="mb-4">
                                            <input type="text" id="scan" value="" autofocus
                                                placeholder="Scan Barcode"
                                                class="focus:shadow-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding p-3 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                        </div>
                                    </form>
                                </div>
                                <div
                                    class="border-black/12.5 rounded-b-2xl border-t-0 border-solid p-6 text-center pt-0 px-1 sm:px-6">
                                    <p class="mx-auto mb-6 leading-normal text-sm text-white">Untuk melihat daftar
                                        barang silahkan klik
                                        <a href="#"
                                            class="font-semibold text-blue-300 hover:text-blue-100 underline">disini</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const btnScan = document.getElementById('btn-scan');
                const readerDiv = document.getElementById('reader');
                const inputBarcode = document.getElementById('scan');

                // Elemen yang akan diupdate datanya
                const elNamaBarang = document.getElementById('nama_barang');
                const elKategoriSatuan = document.getElementById('kategori_satuan');
                const elHargaBarang = document.getElementById('harga_barang');

                let html5QrcodeScanner = null;

                // --- 1. FUNGSI UNTUK MENGAMBIL DATA KE DATABASE VIA AJAX ---
                function fetchProductData(barcode) {
                    if (!barcode) return;

                    // Beri indikator loading sementara
                    elNamaBarang.innerText = "Mencari data...";
                    elKategoriSatuan.innerText = "-";
                    elHargaBarang.value = "Menghitung...";

                    $.ajax({
                        url: "/fetch-barang",
                        method: 'GET',
                        data: {
                            kode_barang: barcode // PERBAIKAN: Gunakan parameter 'barcode', bukan 'kodeBarang'
                        },
                        success: function(response) {
                            if (response && response.data && response.data.barangs) {
                                $("#nama_barang").text(response.data.barangs['nama'] || '-');
                                $("#kategori_satuan").text(
                                    (response.data.barangs['kategori'] || '-') + " / " + (response.data
                                        .barangs['satuan'] || '-')
                                );

                                // Kosongkan input scan setelah sukses (opsional, tergantung kebutuhan UX)
                                $("#scan").val("");

                                // Format Ribuan Harga
                                let harga = response.data['harga_jual'];
                                if (harga) {
                                    // PERBAIKAN: Gunakan toLocaleString untuk format ribuan yang lebih rapi dan aman
                                    let hargaFormatted = Number(harga).toLocaleString('id-ID');
                                    $("#harga_barang").val(hargaFormatted);
                                } else {
                                    $("#harga_barang").val("0");
                                }
                            } else {
                                $("#nama_barang").text("Data tidak lengkap");
                                $("#kategori_satuan").text("-");
                                $("#harga_barang").val("");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error Fetching Data:", error);
                            $("#nama_barang").text("Barang tidak ditemukan");
                            $("#kategori_satuan").text("-");
                            $("#harga_barang").val("");
                            $("#scan").val(""); // Kosongkan input jika error
                        }
                    });
                } // PERBAIKAN: Tutup kurung kurawal fungsi fetchProductData di sini

                // --- 2. AKSI SAAT TOMBOL KAMERA DIKLIK ---
                btnScan.addEventListener('click', function() {
                    readerDiv.style.display = 'block';
                    if (html5QrcodeScanner) return;

                    html5QrcodeScanner = new Html5QrcodeScanner(
                        "reader", {
                            fps: 10,
                            qrbox: {
                                width: 250,
                                height: 250
                            },
                            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
                        }, false
                    );

                    html5QrcodeScanner.render((decodedText) => {
                        // Isi input text
                        if (inputBarcode) inputBarcode.value = decodedText;

                        // Panggil aksi Fetch Data
                        fetchProductData(decodedText);

                        // Hentikan kamera setelah berhasil scan
                        html5QrcodeScanner.clear().then(() => {
                            readerDiv.style.display = 'none';
                            html5QrcodeScanner = null;
                        });
                    }, (error) => {
                        // Abaikan error per frame
                    });
                });

                // --- 3. AKSI SAAT KETIK MANUAL DAN TEKAN ENTER DI INPUT BARCODE ---
                if (inputBarcode) {
                    inputBarcode.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault(); // Mencegah form tersubmit/reload halaman
                            fetchProductData(this.value);
                        }
                    });
                }
            });
        </script>
    @endpush
</x-home>
