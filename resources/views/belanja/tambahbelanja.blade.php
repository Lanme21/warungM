<x-layouts>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.css">
    <div class="w-full p-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-0">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <form action="{{ route('belanja.store') }}" method="POST">
                        @csrf

                        <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-6 pb-0">
                            <div class="flex items-center">
                                <p class="mb-0 font-bold dark:text-white/80">Tambah Belanja</p>
                                <button type="submit"
                                    class="inline-block px-8 py-2 mb-4 ml-auto font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">Simpan</button>
                            </div>
                        </div>
                        <div class="flex-auto p-6">
                            <p class="leading-normal uppercase dark:text-white dark:opacity-60 text-sm">Memasukan ke
                                daftar belanja</p>
                            <div class="flex flex-wrap -mx-3">
                                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                                    <div class="mb-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <label for="kode_barang"
                                                class="inline-block ml-1 font-bold text-xs text-slate-700 dark:text-white/80">
                                                Kode Barang
                                            </label>
                                            <button type="button" id="btn-scan"
                                                class="inline-block px-3 py-1 text-xs font-bold text-white bg-blue-500 rounded-lg hover:bg-blue-700 transition-all">
                                                📷 Scan Barcode
                                            </button>
                                        </div>

                                        <div id="reader" class="w-full mb-2" style="display: none;"></div>

                                        <input type="text" name="kode_barang" id="kode_barang"
                                            value="{{ old('kode_barang') }}" placeholder="Scan barcode yang tersedia"
                                            class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none"
                                            list="listlist" />

                                        <datalist id="listlist">
                                            @foreach ($barang as $item)
                                                <option value="{{ $item->kode }}"
                                                    {{ old('kode_barang') == $item->kode ? 'selected' : '' }}>
                                                    {{ $item->kode }} => {{ $item->nama }} - {{ $item->satuan }}
                                                </option>
                                            @endforeach
                                        </datalist>

                                        @error('kode_barang')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                                    <div class="mb-4">
                                        <label for="harga_beli"
                                            class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Harga
                                            Beli</label>
                                        <input type="number" name="harga_beli" value="{{ old('harga_beli') }}"
                                            step="500" placeholder="Masukkan harga beli"
                                            class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                                        @error('harga_beli')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                                    <div class="mb-4">
                                        <label for="harga_jual"
                                            class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Harga
                                            Jual</label>
                                        <input type="number" name="harga_jual" value="{{ old('harga_jual') }}"
                                            step="500" placeholder="Masukkan harga jual"
                                            class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                                        @error('harga_jual')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                                    <div class="mb-4">
                                        <label for="jumlah"
                                            class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Jumlah</label>
                                        <input type="number" name="jumlah" value="{{ old('jumlah') }}"
                                            placeholder="Masukkan jumlah item"
                                            class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                                        @error('jumlah')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                    </form>


                </div>
            </div>
        </div>
        <div class="w-full max-w-full px-3 mt-6 shrink-0 md:w-4/12 md:flex-0 md:mt-0">
            <div
                class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                <img class="w-full rounded-t-2xl" src={{ asset('assets/img/background-baru.png') }}
                    alt="profile cover image">

            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const btnScan = document.getElementById('btn-scan');
                const readerDiv = document.getElementById('reader');
                const inputKodeBarang = document.getElementById('kode_barang');
                let html5QrcodeScanner = null;

                btnScan.addEventListener('click', function() {
                    // Tampilkan kotak scanner
                    readerDiv.style.display = 'block';

                    // Jika scanner sudah berjalan, cegah inisialisasi ulang
                    if (html5QrcodeScanner) return;

                    // Inisialisasi scanner
                    html5QrcodeScanner = new Html5QrcodeScanner(
                        "reader", {
                            fps: 10,
                            qrbox: {
                                width: 250,
                                height: 250
                            },
                            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
                        },
                        false
                    );

                    // Fungsi saat barcode berhasil discan
                    function onScanSuccess(decodedText, decodedResult) {
                        // 1. Isi inputan kode_barang
                        inputKodeBarang.value = decodedText;

                        // 2. Hentikan scanner dan sembunyikan wadah kamera
                        html5QrcodeScanner.clear().then(() => {
                            readerDiv.style.display = 'none';
                            html5QrcodeScanner = null;

                            // 3. Trigger event change (penting jika Anda menggunakan JS lain 
                            // yang mendengarkan perubahan pada input ini)
                            inputKodeBarang.dispatchEvent(new Event('change'));

                            // 4. Fokuskan otomatis ke input harga beli setelah scan
                            document.querySelector('input[name="harga_beli"]').focus();
                        }).catch(error => {
                            console.error("Gagal menghentikan scanner.", error);
                        });
                    }

                    function onScanFailure(error) {
                        // Abaikan error per frame
                    }

                    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                });
            });
        </script>
    @endpush


</x-layouts>
