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
                const elNamaBarang = document.getElementById('nama_barang');
                const elKategoriSatuan = document.getElementById('kategori_satuan');
                const elHargaBarang = document.getElementById('harga_barang');
                const inputScan = document.getElementById('scan');
                const readerDiv = document.getElementById('reader');
                const btnScan = document.getElementById('btn-scan');

                let html5QrcodeScanner = null;

                function fetchProductData(barcode) {
                    if (!barcode) return;

                    // Pastikan barcode dalam bentuk string murni dan bersih
                    const cleanBarcode = barcode.trim();

                    elNamaBarang.innerText = "Mencari...";

                    $.ajax({
                        url: "/cek-harga",
                        method: 'GET',
                        data: {
                            kode_barang: cleanBarcode
                        },
                        success: function(response) {
                            if (response && response.data) {
                                const b = response.data;
                                elNamaBarang.innerText = b.nama || "Nama tidak tersedia";
                                elKategoriSatuan.innerText = (b.kategori || "-") + " / " + (b.satuan ||
                                    "-");
                                const harga = b.etalase ? b.etalase.harga_jual : 0;
                                elHargaBarang.value = Number(harga).toLocaleString('id-ID');
                                inputScan.value = "";
                            }
                        },
                        error: function() {
                            elNamaBarang.innerText = "Barang Tidak Ditemukan";
                            elKategoriSatuan.innerText = "-";
                            elHargaBarang.value = "0";
                        }
                    });
                }

                btnScan.addEventListener('click', function() {
                    readerDiv.style.display = 'block';

                    if (!html5QrcodeScanner) {
                        html5QrcodeScanner = new Html5Qrcode("reader");
                    }

                    // Konfigurasi khusus: Memaksa membaca EAN-13
                    const config = {
                        fps: 10,
                        qrbox: 250,
                        supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA],
                        formatsToSupport: [Html5QrcodeSupportedFormats.EAN_13]
                    };

                    html5QrcodeScanner.start({
                            facingMode: "environment"
                        },
                        config,
                        (decodedText) => {
                            // Tambahkan delay kecil untuk memastikan sistem menangkap seluruh digit
                            setTimeout(() => {
                                inputScan.value = decodedText;
                                fetchProductData(decodedText);

                                html5QrcodeScanner.stop().then(() => {
                                    readerDiv.style.display = 'none';
                                }).catch((err) => {
                                    console.error("Gagal menghentikan scanner", err);
                                });
                            }, 200);
                        },
                        (errorMessage) => {
                            // Abaikan error per frame
                        }
                    ).catch((err) => {
                        alert("Tidak dapat mengakses kamera: " + err);
                    });
                });

                inputScan.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        fetchProductData(this.value);
                    }
                });
            });
        </script>
    @endpush
</x-home>
